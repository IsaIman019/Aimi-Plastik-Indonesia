@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb --}}
        <div class="text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-orange-600">Beranda</a> / 
            <span class="text-gray-900">Profil Saya</span>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- SIDEBAR KIRI --}}
            <div class="w-full lg:w-1/4">
                {{-- Kartu User --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200 border border-gray-300">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="overflow-hidden">
                        <h3 class="font-bold text-gray-900 truncate">{{ $user->name }}</h3>
                        <p class="text-xs text-gray-500 truncate">Member Pelanggan</p>
                    </div>
                </div>

                {{-- Menu Navigasi --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <nav class="flex flex-col">
                        {{-- 1. AKUN SAYA (AKTIF) --}}
                        <a href="{{ route('pelanggan.profile') }}" class="flex items-center gap-3 px-6 py-4 text-sm font-bold text-orange-600 bg-orange-50 border-l-4 border-orange-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profil Biodata
                        </a>
                        
                        {{-- 2. PESANAN SAYA --}}
                        <a href="{{ route('pelanggan.orders.index') }}" class="flex items-center gap-3 px-6 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-orange-600 transition border-l-4 border-transparent">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Pesanan Saya
                            @if(isset($pendingOrders) && $pendingOrders > 0)
                                <span class="ml-auto bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full">{{ $pendingOrders }}</span>
                            @endif
                        </a>

                        {{-- 3. ALAMAT PENGIRIMAN (LINK KE HALAMAN BARU) --}}
                        <a href="{{ route('pelanggan.address.index') }}" class="flex items-center gap-3 px-6 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-orange-600 transition border-l-4 border-transparent">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Alamat Pengiriman
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="border-t border-gray-100">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-6 py-4 text-sm font-medium text-red-600 hover:bg-red-50 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            {{-- KONTEN UTAMA (BIODATA) --}}
            <div class="w-full lg:w-3/4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Biodata Diri</h2>
                    
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-200 text-sm font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('pelanggan.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- 1. FOTO PROFIL --}}
                        <div class="flex flex-col md:flex-row items-center gap-8 mb-8 p-6 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="w-24 h-24 rounded-full overflow-hidden bg-white border-4 border-white shadow-md relative">
                                <img id="preview-avatar" 
                                     src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random' }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            
                            <div class="flex-1 text-center md:text-left">
                                <h3 class="font-bold text-gray-900">Foto Profil</h3>
                                <p class="text-xs text-gray-500 mb-3">Format: .JPG, .PNG (Max. 2MB)</p>
                                
                                <label class="cursor-pointer bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-orange-600 transition inline-block shadow-lg">
                                    Pilih Foto Baru
                                    <input type="file" name="avatar" class="hidden" onchange="previewImage(event)" accept="image/*">
                                </label>
                            </div>
                        </div>

                        <div class="space-y-6">
                            {{-- 2. DATA DIRI --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 transition px-4 py-3">
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                                    <input type="email" value="{{ $user->email }}" class="w-full border-gray-200 bg-gray-100 text-gray-500 rounded-xl px-4 py-3 cursor-not-allowed" readonly>
                                    <p class="text-[10px] text-gray-400 mt-1">*Email tidak dapat diubah</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp / HP</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full border-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 transition px-4 py-3" placeholder="08123456789">
                            </div>

                            {{-- NOTE: FORM ALAMAT DIHAPUS DARI SINI KARENA SUDAH ADA HALAMAN SENDIRI --}}

                            {{-- 3. GANTI PASSWORD --}}
                            <div class="pt-6 border-t border-gray-100">
                                <h3 class="font-bold text-gray-900 mb-4">Ganti Password (Opsional)</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                                        <input type="password" name="password" class="w-full border-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 transition px-4 py-3" placeholder="********">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 transition px-4 py-3" placeholder="********">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mt-10 flex justify-end">
                            <button type="submit" class="bg-orange-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-orange-700 transition shadow-lg shadow-orange-200">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview-avatar');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection