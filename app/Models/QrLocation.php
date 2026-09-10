<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'latitude',
        'longitude',
        'radius',
        'is_active',
    ];

    public function tokens()
    {
        return $this->hasMany(QrToken::class, 'qr_location_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}