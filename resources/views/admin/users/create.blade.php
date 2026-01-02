@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    @include('components.admin-sidebar')
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Tambah Pengguna Baru</h1>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full border rounded-lg px-4 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" class="w-full border rounded-lg px-4 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" class="w-full border rounded-lg px-4 py-2" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2">Role (Hak Akses)</label>
                    <select name="role" class="w-full border rounded-lg px-4 py-2">
                        <option value="pelanggan">Pelanggan</option>
                        <option value="karyawan">Karyawan</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700">Buat User</button>
            </form>
        </div>
    </div>
</div>
@endsection