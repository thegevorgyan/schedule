@extends('layouts.app')
@section('content')
  <v-layout justify-center row mx-2 my-4>
    <v-flex xs12 md10 xl8>    
      <employee url="{{ url('/') }}" username="{{ $username }}"></employee>
    </v-flex>
  </v-layout>
@endsection
