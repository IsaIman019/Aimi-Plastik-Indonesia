@extends('layouts.app')
@section('title', 'Produk')
@push('styles')
<link href="{{ asset('assets/css/admin/produk/styles.css') }}" rel="stylesheet">
@endpush

@section('content')
    @yield('render')
@endsection

