<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrToken extends Model
{
    protected $fillable = [
        'qr_location_id',
        'token',
        'date',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    protected $casts = [
        'date' => 'date',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function location()
    {
        return $this->belongsTo(QrLocation::class, 'qr_location_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}