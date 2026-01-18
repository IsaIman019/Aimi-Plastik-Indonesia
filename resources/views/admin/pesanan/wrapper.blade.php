@extends('layouts.app')
@section('title', 'Pesanan')
@push('styles')
<link href="{{ asset('assets/css/admin/pesanan/styles.css') }}" rel="stylesheet">
@endpush

@section('content')
@yield('render')
@endsection