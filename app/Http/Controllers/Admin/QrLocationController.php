<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrLocation;
use Illuminate\Http\Request;

class QrLocationController extends Controller
{
    public function index()
    {
        $locations = QrLocation::latest()->paginate(10);
        return view('admin.qr-locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.qr-locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'code' => ['required', 'string', 'max:50', 'unique:qr_locations,code'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'radius' => ['required', 'integer', 'min:1', 'max:500'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        QrLocation::create($validated);

        return redirect()
            ->route('admin.qr-locations.index')
            ->with('success', 'Data lokasi QR berhasil ditambahkan.');
    }

    public function edit(QrLocation $qr_location)
    {
        return view('admin.qr-locations.edit', ['location' => $qr_location]);
    }

    public function update(Request $request, QrLocation $qr_location)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'code' => ['required', 'string', 'max:50', 'unique:qr_locations,code,' . $qr_location->id],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'radius' => ['required', 'integer', 'min:1', 'max:500'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $qr_location->update($validated);

        return redirect()
            ->route('admin.qr-locations.index')
            ->with('success', 'Data lokasi QR berhasil diperbarui.');
    }

    public function destroy(QrLocation $qr_location)
    {
        $qr_location->delete();

        return redirect()
            ->route('admin.qr-locations.index')
            ->with('success', 'Data lokasi QR berhasil dihapus.');
    }
}