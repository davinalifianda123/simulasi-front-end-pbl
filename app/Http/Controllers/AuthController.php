<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            // Kirim POST ke backend API login
            $response = Http::post('http://localhost:8001/api/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['access_token']) && isset($data['refresh_token'])) {
                // FORGET cookie sebelumnya (wajib untuk memastikan browser buang value lama)
                Cookie::forget('jwt_token');
                Cookie::forget('refresh_token');

                // Buat cookie baru
                $accessCookie = cookie('jwt_token', $data['access_token'], 30, '/', null, false, false);
                $refreshCookie = cookie('refresh_token', $data['refresh_token'], 10080, '/', null, false, false);

                // Kembalikan view dengan cookie (tanpa redirect)
                return redirect()->route('dashboard.index')
                    ->withCookie($accessCookie)
                    ->withCookie($refreshCookie)
                    ->with('success', 'Login berhasil!');
            }

            return back()->withErrors(['login' => 'Login gagal, token tidak diterima.']);
        } catch (\Exception $e) {
            return back()->withErrors(['login' => 'Login gagal: ' . $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        // Hapus kedua cookie: jwt_token dan refresh_token
        return redirect('/login')
            ->withCookie(Cookie::forget('jwt_token'))
            ->withCookie(Cookie::forget('refresh_token'))
            ->with('success', 'Logout berhasil!');
    }
}