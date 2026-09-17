<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrLocation;
use App\Models\QrToken;
use Illuminate\Support\Str;

class QrTokenController extends Controller
{
    public function generate()
    {
        $locations = QrLocation::where('is_active', true)->get();

        foreach ($locations as $location) {
            $existing = QrToken::where('qr_location_id', $location->id)
                ->whereDate('date', today())
                ->first();

            if ($existing) {
                continue;
            }

            QrToken::create([
                'qr_location_id' => $location->id,
                'token' => Str::random(64),
                'date' => today(),
                'valid_from' => now()->startOfDay(),
                'valid_until' => now()->endOfDay(),
                'is_active' => true,
            ]);
        }

        return back()->with('success', 'Token QR berhasil dibuat.');
    }
}