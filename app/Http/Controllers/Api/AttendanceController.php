<?php

namespace App\Http\Controllers\Api;

use App\Helpers\GeoHelper;
use App\Http\Controllers\Controller;
use App\Models\QrToken;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Pertemuan 7 + 8: validasi QR token dan lokasi GPS.
     *
     * Client hanya MENGIRIM data (qr_token, latitude, longitude).
     * Server yang MENENTUKAN valid atau tidaknya.
     * Absensi belum disimpan (itu materi pertemuan berikutnya).
     */
    public function scan(Request $request)
    {
        $request->validate([
            'qr_token'  => ['required', 'string'],
            'latitude'  => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        // Identitas siswa diambil dari token login, BUKAN dari request.
        $student = $request->user()->student;

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Akun belum terhubung dengan data siswa.',
            ], 422);
        }

        // 1. Validasi QR: ada, aktif, hari ini, masih berlaku
        $qrToken = QrToken::with('location')
            ->where('token', $request->qr_token)
            ->where('is_active', true)
            ->whereDate('date', today())
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->first();

        if (!$qrToken) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau sudah kedaluwarsa.',
            ], 422);
        }

        // 2. Validasi lokasi QR
        $location = $qrToken->location;

        if (!$location || !$location->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi QR tidak aktif.',
            ], 422);
        }

        if ($location->latitude === null || $location->longitude === null) {
            return response()->json([
                'success' => false,
                'message' => 'Koordinat lokasi QR belum diatur oleh admin.',
            ], 422);
        }

        // 3. Haversine: jarak siswa ke lokasi QR (meter)
        $distance = GeoHelper::distance(
            (float) $request->latitude,
            (float) $request->longitude,
            (float) $location->latitude,
            (float) $location->longitude
        );

        // 4. Bandingkan dengan radius lokasi
        if ($distance > $location->radius) {
            return response()->json([
                'success' => false,
                'message' => 'Anda berada di luar radius lokasi absensi.',
                'data' => [
                    'distance' => round($distance, 2),
                    'radius'   => $location->radius,
                    'location' => $location->name,
                ],
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'QR dan lokasi valid.',
            'data' => [
                'student' => [
                    'id'   => $student->id,
                    'nis'  => $student->nis,
                    'name' => $student->full_name,
                ],
                'qr' => [
                    'token_id'    => $qrToken->id,
                    'date'        => $qrToken->date,
                    'valid_until' => $qrToken->valid_until,
                ],
                'location' => [
                    'name'      => $location->name,
                    'code'      => $location->code,
                    'latitude'  => $location->latitude,
                    'longitude' => $location->longitude,
                    'radius'    => $location->radius,
                ],
                'gps' => [
                    'latitude'  => (float) $request->latitude,
                    'longitude' => (float) $request->longitude,
                    'distance'  => round($distance, 2),
                ],
            ],
        ]);
    }
}
