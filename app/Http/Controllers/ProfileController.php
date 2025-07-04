<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get("https://gudangku.web.id/api/profile/{$id}");

        $user = null;
        if ($response->successful()) {
            $result = json_decode($response->body());
            $user = $result->data;
            if ($user && property_exists($user, 'created_at') && $user->created_at) {
                $user->created_at = Carbon::parse($user->created_at);
            }
            if ($user && property_exists($user, 'updated_at') && $user->updated_at) {
                $user->updated_at = Carbon::parse($user->updated_at);
            }
        }

        return view('profile.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get("https://gudangku.web.id/api/profile/{$id}");

        $user = null;
        if ($response->successful()) {
            $result = json_decode($response->body());
            $user = $result->data;
            if ($user && property_exists($user, 'created_at') && $user->created_at) {
                $user->created_at = Carbon::parse($user->created_at);
            }
            if ($user && property_exists($user, 'updated_at') && $user->updated_at) {
                $user->updated_at = Carbon::parse($user->updated_at);
            }
        }

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->patch("https://gudangku.web.id/api/profile/{$id}", [
            'nama_user' => $request->input('nama_user'),
            'current_password' => $request->input('current_password'), // Include current_password
            'password' => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation'),
        ]);

        if ($response->successful()) {
            $result = json_decode($response->body());
            return redirect()->route('profile.show', $id)->with('success', $result->message);
        } else {
            $errors = json_decode($response->body())->errors ?? ['general' => 'Terjadi kesalahan saat memperbarui pengguna.'];
            $message = json_decode($response->body())->message ?? 'Gagal memperbarui data pengguna.';

            if ($response->status() === 422) {
                return redirect()->back()->withErrors($errors)->withInput()->with('error', $message);
            }

            return redirect()->back()->with('error', $message)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
