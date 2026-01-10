@extends('layouts.app')
@section('title', 'Kategori Produk')
@push('styles')
<link href="{{ asset('assets/css/admin/categories/styles.css') }}" rel="stylesheet">
@endpush

@section('content')
    @yield('render')
@endsection

