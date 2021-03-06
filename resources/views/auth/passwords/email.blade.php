@extends('layouts.app')
@section('content')
    <v-container fluid grid-list-lg>
        <v-layout justify-center row>
            <v-flex xs12 sm10 md8 lg6 xl4>    
                <v-card color="blue-grey lighten-4" class="white--text" >
                    <v-card-title style="background:#435b71">                     
                        <h5 style="margin:0">{{ __('Reset Password') }}</h5>                   
                    </v-card-title>
                    <v-card-actions>
                        <v-layout justify-center row>
                            <v-flex xs8 md6>
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif    
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf        
                                    <div>
                                        <label class="d-none form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"></label>
                                        <v-text-field
                                            id="email"
                                            type="email"                                                
                                            label="{{ __('E-Mail Address') }}"                                                
                                            name="email"
                                            value="{{ old('email') }}"                                                     
                                            required
                                            placeholder="{{ old('email') }}"                                                    
                                        ></v-text-field>                                      
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>       
                                    <div>
                                        <v-btn        
                                            block                                
                                            color="success"
                                            type="submit"
                                            style="background-color: #4caf50; margin:8px 0"                                                
                                        >
                                        <v-icon left >email</v-icon>
                                            {{ __('Send Password Reset Link') }}          
                                        </v-btn>  
                                    </div>
                                </form>
                            </v-flex>
                        </v-layout>                               
                    </v-card-actions>
                </v-card>
            <v-flex>
        </v-layout>
    </v-container>
@endsection
