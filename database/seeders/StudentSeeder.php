<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Data siswa kelas beserta akun login.
 *
 *  - Email    : nama lengkap huruf kecil dipisah titik, mis. aan.darawati@absensi.test
 *  - Password : NIS (disimpan ter-hash, bukan teks biasa)
 *
 * Aman dijalankan berulang kali: siswa yang sudah ada tidak dibuat dua kali
 * dan password yang sudah diganti siswa TIDAK direset.
 *
 * Jalankan:  php artisan db:seed --class=StudentSeeder
 */
class StudentSeeder extends Seeder
{
    // Kelas tempat semua siswa dimasukkan (dibuat otomatis jika belum ada).
    private const CLASS_NAME = 'XII RPL';
    private const MAJOR = 'RPL';

    // Domain email akun siswa.
    private const EMAIL_DOMAIN = 'absensi.test';

    // [nama lengkap, NIS]
    private const STUDENTS = [
        ['Aan Darawati', '102425181'],
        ['Aldyansah', '102425182'],
        ['Aleya Nurmalia', '102425183'],
        ['Aulia Nurul Septiani', '102425184'],
        ['Ayu Wandira', '102425186'],
        ['Azzahra Cahya Qirani', '102425187'],
        ['Dede Angga Saputra', '102425189'],
        ['Elsya Zaqiyatul Insani', '102425190'],
        ['Farihatul Zannah', '102425191'],
        ['Fikri Hamdan Maulana', '102425192'],
        ['Hani Khairani', '102425193'],
        ['Iqbal Saepul Rohman', '102425194'],
        ['Khoiriyatu Nisa', '102425195'],
        ['Lya Maelyatun Zhahra', '102425196'],
        ['M. Dirli Iman Pratama', '102425203'],
        ['M. Rizal', '102425197'],
        ['M. Rizki Purnama Hartono', '102425198'],
        ['Meta Octaviani Fadilah', '102425199'],
        ['Mia Agustina', '102425200'],
        ['Moh. Yazid Gani', '102425201'],
        ['M. Dede Angga', '102425202'],
        ['Naesa Nursafani', '102425204'],
        ['Nandar Iskandar', '102425205'],
        ['N. Ghinna Raesita', '102425206'],
        ['Prisa Karin Maulida', '102425207'],
        ['Raisya Zulfaturahma', '102425208'],
        ['Rasya Alkarim Ruswandi', '102425209'],
        ['Sabiilaa Ainul Jannah', '102425172'],
        ['Siti Nurmala Latifa Zahra', '102425211'],
        ['Sri Tika Kartika', '102425212'],
        ['Surya Indra Nugraha Putra', '102425213'],
        ['Tio Saputra', '102425214'],
        ['Zahra Nurfazrilianti', '102425216'],
    ];

    public function run(): void
    {
        $class = ClassRoom::firstOrCreate(
            ['class_name' => self::CLASS_NAME],
            ['major' => self::MAJOR]
        );

        DB::transaction(function () use ($class) {
            $this->removeDemoAccount();

            foreach (self::STUDENTS as [$name, $nis]) {
                $user = User::firstOrCreate(
                    ['email' => $this->emailFor($name)],
                    [
                        'name' => $name,
                        'password' => Hash::make($nis),
                        'role' => 'siswa',
                    ]
                );

                Student::updateOrCreate(
                    ['nis' => $nis],
                    [
                        'user_id' => $user->id,
                        'full_name' => $name,
                        'class_id' => $class->id,
                    ]
                );
            }
        });

        $this->command?->info(count(self::STUDENTS) . ' siswa siap (kelas ' . self::CLASS_NAME . ').');
    }

    private function emailFor(string $name): string
    {
        $slug = Str::of($name)
            ->lower()
            ->replaceMatches('/[^a-z0-9\s]/', '')
            ->squish()
            ->replace(' ', '.');

        return $slug . '@' . self::EMAIL_DOMAIN;
    }

    /** Hapus akun contoh "Siswa Demo" dari seeder lama (StudentApiSeeder). */
    private function removeDemoAccount(): void
    {
        $demo = User::where('email', 'siswa@absensi.test')->where('role', 'siswa')->first();

        if (! $demo) {
            return;
        }

        Student::where('user_id', $demo->id)->delete();
        $demo->tokens()->delete();
        $demo->delete();
    }
}
