@extends('layouts.app')
@section('title', 'Promo & Diskon')
@push('styles')
<link href="{{ asset('assets/css/admin/promo/styles.css') }}" rel="stylesheet">
@endpush

@section('content')
    @yield('render')
@endsection

