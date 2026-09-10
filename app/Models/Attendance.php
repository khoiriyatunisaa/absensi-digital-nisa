<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'qr_location_id',
        'qr_token_id',
        'attendance_date',
        'attendance_time',
        'status',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'attendance_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function qrLocation()
    {
        return $this->belongsTo(QrLocation::class);
    }

    public function qrToken()
    {
        return $this->belongsTo(QrToken::class);
    }
}