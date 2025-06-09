<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $token = $request->cookie('jwt_token');

        $response = Http::withToken($token)->get('https://gudangku.web.id/api/authenticated-user');

        $userResponse = json_decode($response->body());
        $user = $userResponse->data;

        foreach ($roles as $role) {
            if ($role == $user->role) {
                $request->attributes->set('id_user', $user->id);
                $request->attributes->set('nama_user', $user->nama_user);
                $request->attributes->set('nama_role', $user->role);
                $request->attributes->set('lokasi', $user->lokasi);
                $request->attributes->set('id_lokasi', $user->id_lokasi);
                return $next($request);
            }
        }

        abort(401, 'Anda tidak punya akses ke halaman ini!');
    }

}
