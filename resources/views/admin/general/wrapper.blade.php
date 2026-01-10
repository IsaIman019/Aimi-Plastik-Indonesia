@extends('layouts.app')
@section('title', 'Master General')
@push('styles')
<link href="{{ asset('assets/css/admin/general/styles.css') }}" rel="stylesheet">
@endpush

@section('content')
@yield('render')
@endsection