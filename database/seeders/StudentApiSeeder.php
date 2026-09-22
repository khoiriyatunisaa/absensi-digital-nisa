<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentApiSeeder extends Seeder
{
    public function run(): void
    {
        $classRoom = ClassRoom::first();

        $user = User::firstOrCreate(
            ['email' => 'siswa@absensi.test'],
            [
                'name' => 'Siswa Demo',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]
        );

        Student::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nis' => '123456789',
                'full_name' => 'Siswa Demo',
                'class_id' => $classRoom?->id,
            ]
        );
    }
}
