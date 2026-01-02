@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    @include('components.admin-sidebar')
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Data User</h1>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded-lg px-4 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded-lg px-4 py-2 bg-gray-100" readonly>
                    <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah sembarangan.</p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Password Baru (Opsional)</label>
                    <input type="password" name="password" class="w-full border rounded-lg px-4 py-2" placeholder="Biarkan kosong jika tidak ingin mengganti">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2">Role</label>
                    <select name="role" class="w-full border rounded-lg px-4 py-2">
                        <option value="pelanggan" {{ $user->role == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                        <option value="karyawan" {{ $user->role == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-orange-600 text-white font-bold rounded-lg hover:bg-orange-700">Update User</button>
            </form>
        </div>
    </div>
</div>
@endsection