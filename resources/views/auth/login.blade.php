@extends('layouts.app')
@section('content')
    <v-container fluid grid-list-lg>
        <v-layout justify-center row>
            <v-flex xs12 sm10 md8 lg6 xl4>    
                <v-card color="blue-grey lighten-4" class="white--text" >
                    <v-card-title style="background:#435b71">                     
                        <h5 style="margin:0">User {{ __('Login') }}</h5>                   
                    </v-card-title>
                    <v-card-actions>
                        <v-layout justify-center row>
                            <v-flex xs8 md6>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf                
                                    <div>
                                        <label  class="d-none form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"></label>
                                        <v-text-field
                                            id="email"
                                            type="email"                                                
                                            label="{{ __('E-Mail Address') }}"                                                
                                            name="email"
                                            value=" {{ old('email') }}"                                                     
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
                                        <label class="d-none form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"></label>
                                        <v-text-field
                                            id="password"
                                            type="password"                                            
                                            label="{{ __('Password') }}"                                        
                                            name="password"
                                            value=" "
                                            placeholder="{{ old('password') }}"
                                            required
                                            hide-details
                                        ></v-text-field>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>                                
                                    <div>    
                                        <v-checkbox color="#4caf50" label="{{ __('Remember Me') }}"></v-checkbox>
                                    </div>
                                    <div>                                      
                                        <v-btn 
                                            block                               
                                            color="success"
                                            type="submit"
                                            style="background-color: #4caf50; margin:8px 0"
                                        >
                                            <v-icon left >input</v-icon>
                                            {{ __('Login') }}          
                                        </v-btn> 
                                        <v-btn
                                        block
                                        
                                        flat
                                        style="margin:8px 0"
                                        >       
                                        <a class="btn btn-link" href="{{ route('password.request') }}" >
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                        </v-btn>
                                    </div>
                                       
                                </form>
                            </v-flex>
                        </v-layout>
                    </v-card-actions>
                </v-card>    
            </v-flex>
        </v-layout>
    </v-container>
@endsection
