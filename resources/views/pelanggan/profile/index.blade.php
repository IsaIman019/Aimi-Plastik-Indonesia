@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-orange-600">Beranda</a> /
            <span class="text-gray-900">Profil Saya</span>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            <div class="w-full lg:w-1/4">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200 border border-gray-300">
                        @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                        @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=random"
                            class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="overflow-hidden">
                        <h3 class="font-bold text-gray-900 truncate">{{ $user->nama }}</h3>
                    </div>
                </div>

                {{-- Menu Navigasi --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <nav class="flex flex-col">
                        {{-- 1. AKUN SAYA (AKTIF) --}}
                        <a href="{{ route('pelanggan.profile') }}"
                            class="flex items-center gap-3 px-6 py-4 text-sm font-bold text-orange-600 bg-orange-50 border-l-4 border-orange-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profil Biodata
                        </a>

                        {{-- 2. PESANAN SAYA --}}
                        <a href="{{ route('pelanggan.orders.index') }}"
                            class="flex items-center gap-3 px-6 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-orange-600 transition border-l-4 border-transparent">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Pesanan Saya
                            {{-- @if(isset($pendingOrders) && $pendingOrders > 0)
                            <span
                                class="ml-auto bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full">{{ $pendingOrders }}</span>
                            @endif --}}
                        </a>

                        {{-- 3. ALAMAT PENGIRIMAN (LINK KE HALAMAN BARU) --}}
                        <a href="{{ route('pelanggan.address.index') }}"
                            class="flex items-center gap-3 px-6 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-orange-600 transition border-l-4 border-transparent">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Alamat Pengiriman
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="border-t border-gray-100">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-6 py-4 text-sm font-medium text-red-600 hover:bg-red-50 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
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
                    <div
                        class="mb-6 bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-200 text-sm font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('pelanggan.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- 1. FOTO PROFIL --}}
                        <div
                            class="flex flex-col md:flex-row items-center gap-8 mb-8 p-6 bg-gray-50 rounded-xl border border-gray-100">
                            <div
                                class="w-24 h-24 rounded-full overflow-hidden bg-white border-4 border-white shadow-md relative">
                                <img id="preview-avatar"
                                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->nama).'&background=random' }}"
                                    class="w-full h-full object-cover">
                            </div>

                            <div class="flex-1 text-center md:text-left">
                                <h3 class="font-bold text-gray-900">Foto Profil</h3>
                                <p class="text-xs text-gray-500 mb-3">Format: .JPG, .PNG (Max. 2MB)</p>

                                <label
                                    class="cursor-pointer bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-bold bg-orange-600 transition inline-block shadow-lg">
                                    Pilih Foto Baru
                                    <input type="file" name="avatar" class="hidden" onchange="previewImage(event)"
                                        accept="image/*">
                                </label>

                                {{-- ERROR MSG FOTO --}}
                                @error('avatar')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-6">
                            {{-- 2. DATA DIRI --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                    {{-- Perhatikan name="name" dan value old('name', $user->nama) --}}
                                    <input type="text" name="name" value="{{ old('name', $user->nama) }}"
                                        class="w-full border-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 transition px-4 py-3 @error('name') border-red-500 @enderror">

                                    {{-- ERROR MSG NAMA --}}
                                    @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                                    <input type="email" value="{{ $user->email }}"
                                        class="w-full border-gray-200 bg-gray-100 text-gray-500 rounded-xl px-4 py-3 cursor-not-allowed"
                                        readonly>
                                    <p class="text-[10px] text-gray-400 mt-1">*Email tidak dapat diubah</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp / HP</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                    class="w-full border-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 transition px-4 py-3 @error('phone') border-red-500 @enderror"
                                    placeholder="08123456789">

                                {{-- ERROR MSG PHONE --}}
                                @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- 3. GANTI PASSWORD --}}
                            <div class="pt-6 border-t border-gray-100">
                                <h3 class="font-bold text-gray-900 mb-4">Ganti Password (Opsional)</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                    {{-- PASSWORD BARU --}}
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                                        <div class="relative">
                                            <input type="password" name="password" id="new_password"
                                                class="w-full border-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 transition px-4 py-3 pr-12 @error('password') border-red-500 @enderror"
                                                placeholder="********">

                                            {{-- Tombol Lihat Password --}}
                                            <button type="button" onclick="togglePassword('new_password', this)"
                                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-orange-600 focus:outline-none">
                                                {{-- Ikon Mata (Show) --}}
                                                <svg class="w-5 h-5 block" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                        @error('password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- KONFIRMASI PASSWORD --}}
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi
                                            Password</label>
                                        <div class="relative">
                                            <input type="password" name="password_confirmation" id="confirm_password"
                                                class="w-full border-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 transition px-4 py-3 pr-12"
                                                placeholder="********">

                                            {{-- Tombol Lihat Password --}}
                                            <button type="button" onclick="togglePassword('confirm_password', this)"
                                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-orange-600 focus:outline-none">
                                                <svg class="w-5 h-5 block" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 flex justify-end">
                            <button type="submit"
                                class="bg-orange-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-orange-700 transition shadow-lg shadow-orange-200">
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
        reader.onload = function() {
            var output = document.getElementById('preview-avatar');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const iconSvg = btn.querySelector('svg');

        if (input.type === "password") {
            input.type = "text";
            btn.classList.add('text-orange-600');
            iconSvg.innerHTML =
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';

        } else {
            input.type = "password";
            btn.classList.remove('text-orange-600');
            iconSvg.innerHTML =
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
    }
</script>
@endsection