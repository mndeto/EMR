@extends('layouts.master')

@section('content')

@if(!Auth::check())
@section('title', 'Restricted')

<div style="height: 100%; text-align: center; vertical-align: middle; padding-top: 250px;"> 
<div style="font-size: 72px;">Sorry, not sorry.<br> You don't have the right to view this page.</div>

<a href="/" class="btn btn-primary"><i class="fa fa-hospital-o" aria-hidden="true"></i>
    Go Home</a></div>

@endif


@if(Auth::check())

    @if(Auth::user()->role === "0")
        @include('layouts.pages.admin')
    @elseif(Auth::user()->role === "2")
        @include('layouts.pages.nurse')
    @elseif(Auth::user()->role === "3")
        @include('layouts.pages.doctor')
    @elseif(Auth::user()->role === "4")
        @include('layouts.pages.lab')
    @elseif(Auth::user()->role === "5")
        @include('layouts.pages.pharmacy')
    @else
        @include('layouts.pages.records')
    @endif

     
@endif

@endsection

