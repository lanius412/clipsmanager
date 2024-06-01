@extends('layouts.app')

@section('title', 'Explore Clips | ' . config('app.name'))

@section('header', 'Explore Clips')

@section('contents')
    
    @include('explore.form')

@endsection