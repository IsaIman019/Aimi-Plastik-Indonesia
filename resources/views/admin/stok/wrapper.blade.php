@extends('layouts.app')
@section('title', 'Stok Produk')
@push('styles')
<link href="{{ asset('assets/css/admin/users/styles.css') }}" rel="stylesheet">
@endpush

@section('content')
    @yield('render')
@endsection

