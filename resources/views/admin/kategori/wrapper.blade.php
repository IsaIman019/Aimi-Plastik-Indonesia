@extends('layouts.app')
@section('title', 'Kategori Produk')
@push('styles')
<link href="{{ asset('assets/css/admin/kategori/styles.css') }}" rel="stylesheet">
@endpush

@section('content')
    @yield('render')
@endsection

