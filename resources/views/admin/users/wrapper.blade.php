@extends('layouts.app')
@section('title', 'Master Users')
@push('styles')
<link href="{{ asset('assets/css/admin/users/styles.css') }}" rel="stylesheet">
@endpush

@section('content')
    @yield('render')
@endsection

