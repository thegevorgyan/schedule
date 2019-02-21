@extends('layouts.app')
@section('content')





{{-- {{URL::forceRootUrl(\Config::get('app.url'))}} --}}


  <v-layout justify-center row mx-2 my-4>

    

    @if(Auth::guard('web')->check())
    <p>USER log in</p>
    @else
    <p>USER log out </p>
    @endif




    @if(Auth::guard('admin')->check())
  
    
    {{-- <stat url="{{ url('/') }}" stat="{{ $stat }}"></stat> --}}
    <p>ADMIN log in </p>
    @else
    <p>ADMIN log out </p>
    @endif


   
    {{-- <v-flex xs12 md10 xl8> --}}
      {{-- <home url="{{ url('/') }}" username="{{ $username }}" websites=" {{ $websites }} "></home> --}}
    {{-- </v-flex> --}}
  </v-layout>
@endsection
