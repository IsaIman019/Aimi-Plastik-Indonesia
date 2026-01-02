@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb --}}
        <div class="text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-orange-600">Beranda</a> / 
            <a href="{{ route('pelanggan.profile') }}" class="hover:text-orange-600">Akun</a> /
            <span class="text-gray-900">Daftar Alamat</span>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- SIDEBAR --}}
            <div class="w-full lg:w-1/4">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="overflow-hidden">
                        <h3 class="font-bold text-gray-900 truncate">{{ Auth::user()->name }}</h3>
                        <p class="text-xs text-gray-500 truncate">Member Pelanggan</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <nav class="flex flex-col">
                        <a href="{{ route('pelanggan.profile') }}" class="flex items-center gap-3 px-6 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-orange-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profil Saya
                        </a>
                        <a href="{{ route('pelanggan.orders.index') }}" class="flex items-center gap-3 px-6 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-orange-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Pesanan Saya
                        </a>
                        <a href="{{ route('pelanggan.address.index') }}" class="flex items-center gap-3 px-6 py-4 text-sm font-bold text-orange-600 bg-orange-50 border-l-4 border-orange-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Alamat Pengiriman
                        </a>
                    </nav>
                </div>
            </div>

            {{-- KONTEN UTAMA --}}
            <div class="w-full lg:w-3/4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Alamat Pengiriman</h2>
                        <button onclick="openModal('addModal')" class="bg-gray-900 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-orange-600 transition shadow-lg">
                            + Tambah Alamat
                        </button>
                    </div>

                    @if(session('success'))
                        <div class="mb-6 bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-200 text-sm flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- LIST ALAMAT --}}
                    <div class="space-y-4">
                        @forelse($addresses as $address)
                            <div class="border {{ $address->is_primary ? 'border-orange-500 bg-orange-50/30' : 'border-gray-200' }} rounded-xl p-6 relative group transition hover:shadow-md">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="font-bold text-gray-800">{{ $address->label }}</span>
                                            @if($address->is_primary)
                                                <span class="bg-orange-600 text-white text-[10px] px-2 py-0.5 rounded-full font-bold">Utama</span>
                                            @endif
                                        </div>
                                        <h4 class="font-bold text-lg text-gray-900">{{ $address->recipient_name }}</h4>
                                        <p class="text-gray-600 text-sm mt-1">{{ $address->phone }}</p>
                                        <p class="text-gray-500 text-sm mt-2 max-w-xl leading-relaxed">{{ $address->full_address }}</p>
                                    </div>

                                    <div class="flex flex-col gap-2 items-end">
                                        <div class="flex gap-2">
                                            {{-- TOMBOL EDIT (FIXED) --}}
                                            <button type="button" 
                                                    onclick="editAddress(this)" 
                                                    data-address="{{ json_encode($address) }}"
                                                    class="text-blue-600 text-sm font-bold hover:underline">
                                                Ubah
                                            </button>
                                            
                                            <span class="text-gray-300">|</span>
                                            <form action="{{ route('pelanggan.address.destroy', $address->id) }}" method="POST" onsubmit="return confirm('Hapus alamat ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 text-sm font-bold hover:underline">Hapus</button>
                                            </form>
                                        </div>
                                        @if(!$address->is_primary)
                                            <a href="{{ route('pelanggan.address.primary', $address->id) }}" class="mt-4 px-4 py-2 border border-gray-300 rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50 transition">
                                                Jadikan Utama
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                <p class="text-gray-500">Belum ada alamat tersimpan.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH ALAMAT (FIXED CLASS) --}}
<div id="addModal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl p-6 relative">
        <button onclick="closeModal('addModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <h3 class="text-xl font-bold text-gray-900 mb-6">Tambah Alamat Baru</h3>
        
        <form action="{{ route('pelanggan.address.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Label Alamat</label>
                <input type="text" name="label" placeholder="Contoh: Rumah, Kantor, Kost" class="w-full border-gray-300 rounded-lg" required>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Penerima</label>
                    <input type="text" name="recipient_name" class="w-full border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nomor HP</label>
                    <input type="text" name="phone" class="w-full border-gray-300 rounded-lg" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea name="full_address" rows="3" class="w-full border-gray-300 rounded-lg" placeholder="Jalan, No. Rumah, RT/RW, Kecamatan, Kota, Kode Pos" required></textarea>
            </div>
            <button type="submit" class="w-full bg-orange-600 text-white py-3 rounded-xl font-bold hover:bg-orange-700 transition">Simpan Alamat</button>
        </form>
    </div>
</div>

{{-- MODAL EDIT ALAMAT (FIXED CLASS) --}}
<div id="editModal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl p-6 relative">
        <button onclick="closeModal('editModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <h3 class="text-xl font-bold text-gray-900 mb-6">Ubah Alamat</h3>
        
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <input type="hidden" id="edit_id">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Label Alamat</label>
                <input type="text" name="label" id="edit_label" class="w-full border-gray-300 rounded-lg" required>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Penerima</label>
                    <input type="text" name="recipient_name" id="edit_recipient_name" class="w-full border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nomor HP</label>
                    <input type="text" name="phone" id="edit_phone" class="w-full border-gray-300 rounded-lg" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea name="full_address" id="edit_full_address" rows="3" class="w-full border-gray-300 rounded-lg" required></textarea>
            </div>
            <button type="submit" class="w-full bg-gray-900 text-white py-3 rounded-xl font-bold hover:bg-orange-600 transition">Simpan Perubahan</button>
        </form>
    </div>
</div>

{{-- SCRIPT JAVASCRIPT --}}
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex'); // Tambahkan class flex saat dibuka
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex'); // Hapus class flex saat ditutup
    }

    // Fungsi Edit Address yang Aman
    function editAddress(element) {
        // Ambil data dari attribute 'data-address'
        const addressData = element.getAttribute('data-address');
        const address = JSON.parse(addressData);

        // Isi form edit dengan data
        document.getElementById('edit_label').value = address.label;
        document.getElementById('edit_recipient_name').value = address.recipient_name;
        document.getElementById('edit_phone').value = address.phone;
        document.getElementById('edit_full_address').value = address.full_address;
        
        // Update Action Form URL
        const form = document.getElementById('editForm');
        form.action = "/pelanggan/alamat/" + address.id;

        openModal('editModal');
    }
</script>
@endsection