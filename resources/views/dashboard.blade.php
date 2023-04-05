@php
    $user = Auth::user();
    //see user image exists or not
    if (!Storage::disk('public')->exists($user->image)) {
        $user_image = 'https://ui-avatars.com/api/?name='.$user->name.'&color=7F9CF5&background=EBF4FF&size=256&font-size=0.33&bold=true';
    }else{
        $user_image = asset('storage/'.$user->image);
    }
@endphp
@section('title')
<title>{{ auth()->user()->name }}'s Dashboard</title>
@endsection
@extends('dashboard.app')
@section('exclusive_styles')
@endsection
@section('main')
    <x-sidebar/>
    <div class="right_content">
        <x-navbar />
@endsection
