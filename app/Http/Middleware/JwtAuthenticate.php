<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class JwtAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        $accessToken = $request->cookie('jwt_token');
        $refreshToken = $request->cookie('refresh_token');

        if (!$accessToken && !$refreshToken) {
            return redirect('/login')->with('error', 'Tolong login terlebih dahulu.');
        }

        try {
            // Coba akses endpoint user
            $response = Http::withToken($accessToken)
                            ->get('https://gudangku.web.id/api/authenticated-user');

            if ($response->ok()) {
                return $next($request);
            }

            // Jika access token expired, coba refresh
            if (!$response->ok() && $refreshToken) {
                $refreshResponse = Http::post('https://gudangku.web.id/api/refresh', ['refresh_token' => $refreshToken]);

                if ($refreshResponse->ok()) {
                    $newAccessToken = $refreshResponse['access_token'];

                    // Simpan token baru ke cookie (untuk request selanjutnya)
                    Cookie::queue(cookie('jwt_token', $newAccessToken, 60 * 24));

                    // Validasi ulang dengan token baru
                    $secondTry = Http::withToken($newAccessToken)->get('https://gudangku.web.id/api/authenticated-user');

                    if ($secondTry->ok()) {
                        return $next($request);
                    }
                }
            }

            // Jika tidak bisa refresh atau gagal validasi
            return redirect('/login')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Terjadi kesalahan. Silakan login kembali.');
        }
    }
}