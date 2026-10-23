<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        if ($user->role !== 'siswa') {
            return response()->json([
                'message' => 'Akun ini bukan akun siswa'
            ], 403);
        }

        $token = $user->createToken('mobile-siswa')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load('student.classRoom');
        $student = $user->student;

        return response()->json([
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ],
            'student' => $student ? [
                'id'        => $student->id,
                'nis'       => $student->nis,
                'full_name' => $student->full_name,
                'class'     => $student->classRoom ? [
                    'id'         => $student->classRoom->id,
                    'class_name' => $student->classRoom->class_name,
                    'major'      => $student->classRoom->major,
                ] : null,
            ] : null,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}