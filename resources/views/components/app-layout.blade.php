@props(['title' => 'ERP HRIS'])

@extends('layouts.app')

@section('title', $title)

@section('content')
    {{ $slot }}
@endsection
