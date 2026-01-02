<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        // Validasi input (Opsional tapi sangat disarankan)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:8', // Password boleh kosong jika tidak ingin diganti
        ]);

        /** * Baris ini memberitahu VS Code bahwa $user adalah Model User.
         * Ini akan menghilangkan error "Undefined method 'save'"
         * @var \App\Models\User $user 
         */
        $user = Auth::user();

        // Update data diri standar (Nama & Email)
        $user->name = $request->name;
        $user->email = $request->email;

        // Cek apakah user mengisi kolom password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan ke database
        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}