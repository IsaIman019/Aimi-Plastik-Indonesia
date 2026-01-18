@extends('layouts.app')
@section('title', 'Stok Produk')
@push('styles')
<link href="{{ asset('assets/css/admin/stok/styles.css') }}" rel="stylesheet">
@endpush

@section('content')
    @yield('render')
@endsection

