<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get('http://localhost:8001/api/users');

        $result = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $result = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('users.index', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'users' => $result->users ?? [],
            'headings' => $result->headings ?? [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->cookie('jwt_token');
        $response = Http::withToken($token)->get('http://localhost:8001/api/users/create');

        $roles = [];
        $lokasi = [];

        if ($response->successful()) {
            $data = $response->json('data');
            $roles = $data['roles'] ?? [];
            $lokasi = $data['lokasi'] ?? [];
        }

        return view('users.create', [
            'roles' => $roles,
            'lokasi' => $lokasi,
            'nama_user' => $request->attributes->get('nama_user', ''),
            'nama_role' => $request->attributes->get('nama_role', ''),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->post('http://localhost:8001/api/users', [
            'nama_user' => $request->input('nama_user'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation'),
            'id_role' => $request->input('id_role'),
            'id_lokasi' => $request->input('id_lokasi'),
        ]);

        if ($response->successful()) {
            return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
        } elseif ($response->status() === 422) {
            return redirect()->back()->withErrors($response->json('errors'))->withInput();
        }

        return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan user.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get("http://localhost:8001/api/users/{$id}");

        $user = null;
        if ($response->successful()) {
            $result = json_decode($response->body());
            $user = $result->data ?? null;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('users.show', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $token = request()->cookie('jwt_token');

        $response = Http::withToken($token)->get("http://localhost:8001/api/users/{$id}/edit");

        $result = json_decode($response->body());
        $data = $result->data;

        $nama_user = request()->attributes->get('nama_user');
        $nama_role = request()->attributes->get('nama_role');
        $id_lokasi = request()->attributes->get('id_lokasi');

        return view('users.edit', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'id_lokasi' => $id_lokasi ?? '',
            'user' => $data->user ?? null,
            'roles' => $data->roles ?? [],
            'lokasi' => $data->lokasis ?? [],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $token = request()->cookie('jwt_token');

        $data = $request->all();

        // Cek apakah tombol reset password ditekan
        if ($request->has('reset_password') && $request->input('reset_password') == '1') {
            $data['password'] = 'password123';
        }

        $response = Http::withToken($token)->put("http://localhost:8001/api/users/{$id}", $data);

        if ($response->successful()) {
            $message = $request->has('reset_password') ? 'Password berhasil direset ke default.' : 'User berhasil diperbarui.';
            return redirect()->route('users.index')->with('success', $message);
        } else {
            $result = json_decode($response->body());
            return back()->withInput()->withErrors(['message' => $result->message ?? 'Gagal memperbarui data.']);
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
