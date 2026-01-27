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

            {{-- KONTEN UTAMA --}}
            <div class="w-full lg:w-3/4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Alamat Pengiriman</h2>
                        <button onclick="openModal('addModal')" class="bg-gray-900 text-white px-5 py-2.5 rounded-xl font-bold text-sm bg-orange-600 transition shadow-lg">
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
                            <div class="border {{ $address->is_utama ? 'border-orange-500 bg-orange-50/30' : 'border-gray-200' }} rounded-xl p-6 relative group transition hover:shadow-md">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="font-bold text-gray-800">{{ $address->label }}</span>
                                            @if($address->is_utama)
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
                                        @if(!$address->is_utama)
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
<div id="addModal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl p-6 relative
                    max-h-[90vh] overflow-y-auto">        <button onclick="closeModal('addModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <h3 class="text-xl font-bold text-gray-900 mb-6">Tambah Alamat Baru</h3>
        
        <form action="{{ route('pelanggan.address.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Label Alamat</label>
                <input type="text" name="label" class="w-full border-gray-300 rounded-lg" placeholder="Rumah / Kantor" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Penerima</label>
                    <input type="text" name="nama_penerima" class="w-full border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nomor HP</label>
                    <input type="text" name="phone" class="w-full border-gray-300 rounded-lg" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea name="alamat_lengkap" rows="3" class="w-full border-gray-300 rounded-lg" required></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Provinsi</label>
                    <input type="text" name="provinsi" class="w-full border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kota / Kabupaten</label>
                    <input type="text" name="kota" class="w-full border-gray-300 rounded-lg" required>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kecamatan</label>
                    <input type="text" name="kecamatan" class="w-full border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">RT</label>
                    <input type="text" name="rt" class="w-full border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">RW</label>
                    <input type="text" name="rw" class="w-full border-gray-300 rounded-lg">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Kode Pos</label>
                <input type="text" name="kode_pos" class="w-full border-gray-300 rounded-lg" required>
            </div>

            {{-- MAP --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Titik Lokasi</label>
                <div id="map" class="w-full h-48 rounded-lg border"></div>

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_utama" value="1" class="rounded">
                <label class="text-sm text-gray-700">Jadikan alamat utama</label>
            </div>

            <button type="submit" class="w-full bg-orange-600 text-white py-3 rounded-xl font-bold hover:bg-orange-700 transition">
                Simpan Alamat
            </button>
        </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT ALAMAT (FIXED CLASS) --}}
<div id="editModal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl p-6 relative
                    max-h-[90vh] overflow-y-auto">
        <button onclick="closeModal('editModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <h3 class="text-xl font-bold text-gray-900 mb-6">Ubah Alamat</h3>
        
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Label Alamat</label>
                <input type="text" name="label" id="edit_label" class="w-full border-gray-300 rounded-lg" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Penerima</label>
                    <input type="text" name="nama_penerima" id="edit_nama_penerima" class="w-full border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nomor HP</label>
                    <input type="text" name="phone" id="edit_phone" class="w-full border-gray-300 rounded-lg" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea name="alamat_lengkap" id="edit_alamat_lengkap" rows="3" class="w-full border-gray-300 rounded-lg" required></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Provinsi</label>
                    <input type="text" name="provinsi" id="edit_provinsi" class="w-full border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kota / Kabupaten</label>
                    <input type="text" name="kota" id="edit_kota" class="w-full border-gray-300 rounded-lg" required>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kecamatan</label>
                    <input type="text" name="kecamatan" id="edit_kecamatan" class="w-full border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">RT</label>
                    <input type="text" name="rt" id="edit_rt" class="w-full border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">RW</label>
                    <input type="text" name="rw" id="edit_rw" class="w-full border-gray-300 rounded-lg">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Kode Pos</label>
                <input type="text" name="kode_pos" id="edit_kode_pos" class="w-full border-gray-300 rounded-lg" required>
            </div>

            {{-- MAP --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Titik Lokasi</label>
                <div id="editMap" class="w-full h-48 rounded-lg border"></div>

                <input type="hidden" name="latitude" id="edit_latitude">
                <input type="hidden" name="longitude" id="edit_longitude">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_utama" value="1" id="edit_is_utama">
                <label class="text-sm text-gray-700">Jadikan alamat utama</label>
            </div>

            <button type="submit" class="w-full bg-gray-900 text-white py-3 rounded-xl font-bold  yrewq ``      bg-orange-600 transition">
                Simpan Perubahan
            </button>
        </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
{{-- SCRIPT JAVASCRIPT --}}
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    let editMap, editMarker;

    function editAddress(element) {
        const address = JSON.parse(element.dataset.address);

        edit_label.value = address.label;
        edit_nama_penerima.value = address.nama_penerima;
        edit_phone.value = address.phone;
        edit_alamat_lengkap.value = address.alamat_lengkap;
        edit_provinsi.value = address.provinsi;
        edit_kota.value = address.kota;
        edit_kecamatan.value = address.kecamatan;
        edit_rt.value = address.rt;
        edit_rw.value = address.rw;
        edit_kode_pos.value = address.kode_pos;
        edit_latitude.value = address.latitude;
        edit_longitude.value = address.longitude;
        edit_is_utama.checked = address.is_utama;

        document.getElementById('editForm').action = `/pelanggan/alamat/${address.id}`;

        openModal('editModal');

        setTimeout(() => {
            if (!editMap) {
                editMap = L.map('editMap').setView(
                    [address.latitude ?? -6.2, address.longitude ?? 106.816],
                    15
                );

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(editMap);
            }

            if (editMarker) editMap.removeLayer(editMarker);
            editMarker = L.marker([address.latitude, address.longitude]).addTo(editMap);

            editMap.on('click', e => {
                edit_latitude.value = e.latlng.lat;
                edit_longitude.value = e.latlng.lng;
                editMarker.setLatLng(e.latlng);
            });

            editMap.invalidateSize();
        }, 300);
    }
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('map').setView([-6.200000, 106.816666], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    let marker;

    map.on('click', function (e) {
        const { lat, lng } = e.latlng;

        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    });
});
</script>

@endsection