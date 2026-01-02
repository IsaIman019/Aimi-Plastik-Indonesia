@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    @include('components.admin-sidebar')
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Kelola Pengguna</h1>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-900 font-bold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Bergabung</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users ?? [] as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if($user->role == 'admin')
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-bold">Admin</span>
                            @elseif($user->role == 'karyawan')
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-bold">Karyawan</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs font-bold">Pelanggan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <button class="text-gray-400 hover:text-red-600 font-bold text-xs border border-gray-200 px-3 py-1 rounded">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-6">Data user kosong.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection