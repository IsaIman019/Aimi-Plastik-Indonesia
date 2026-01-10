@extends('layouts.app')
@section('title', 'Master News')
@push('styles')
<link href="{{ asset('assets/css/admin/news/styles.css') }}" rel="stylesheet">
@endpush

@section('content')
@yield('render')
@endsection