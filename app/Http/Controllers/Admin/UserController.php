<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
// PERBAIKAN IMPORT (Penting agar tidak error):
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Daftar user (dengan Pagination)
     */
    public function index()
    {
        // Menggunakan paginate() agar halaman tidak berat saat data banyak
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Detail user beserta order history-nya
     */
    public function show(User $user)
    {
        return view('admin.users.show', [
            'user' => $user->load('orders')
        ]);
    }

    /**
     * Update role user
     */
    public function updateRole(Request $request, User $user)
    {
        // Validasi input
        $request->validate([
            'role' => 'required|in:admin,karyawan,pelanggan'
        ]);

        // CEGAH ADMIN MENGUBAH ROLE DIRI SENDIRI (Agar tidak terkunci)
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri!');
        }

        $user->update([
            'role' => $request->role
        ]);

        return back()->with('success', 'Role user berhasil diperbarui menjadi ' . ucfirst($request->role));
    }

    /**
     * Reset password user ke default
     */
    public function resetPassword(User $user)
    {
        // Password default: password123
        $user->update([
            'password' => Hash::make('password123')
        ]);

        return back()->with('success', 'Password berhasil direset menjadi: password123');
    }

    /**
     * Hapus user (Tambahan fitur)
     */
    public function destroy(User $user)
    {
        // CEGAH ADMIN MENGHAPUS AKUN SENDIRI
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}