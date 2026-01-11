@extends('layouts.app')
@section('title', 'Master Artikel')
@push('styles')
<link href="{{ asset('assets/css/admin/artikel/styles.css') }}" rel="stylesheet">
@endpush

@section('content')
@yield('render')
@endsection