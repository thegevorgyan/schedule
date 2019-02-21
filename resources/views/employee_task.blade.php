@extends('layouts.app')
@section('content')
  <v-layout justify-center row mx-2 my-4>
    <v-flex xs12 md10 xl8>
      <employeetask url="{{ url('/') }}" username="{{ $username }}" tasks=" {{ $tasks }} "></employeetask>
    </v-flex>
  </v-layout>
@endsection
