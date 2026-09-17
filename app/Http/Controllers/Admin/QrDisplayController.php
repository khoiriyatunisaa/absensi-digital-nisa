<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrToken;

class QrDisplayController extends Controller
{
    public function show(QrToken $qrToken)
    {
        abort_unless($qrToken->is_active, 404);
        abort_if(now()->greaterThan($qrToken->valid_until), 404);

        $url = route('qr.scan', $qrToken->token);

        return view('admin.qr.display', compact('qrToken', 'url'));
    }
}