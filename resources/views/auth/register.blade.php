@extends('layouts.app')
@section('content')
    <v-container fluid grid-list-lg>
        <v-layout justify-center row>
            <v-flex xs12 sm10 md8 lg6 xl4>    
                <v-card color="blue-grey lighten-4" class="white--text" >
                    <v-card-title style="background:#435b71">                     
                        <h5 style="margin:0">{{ __('Register') }}</h5>                   
                    </v-card-title>
                    <v-card-actions>
                        <v-layout justify-center row>
                            <v-flex xs8 md6>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf                    
                                    {{-- <div>
                                        <label  class="d-none form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"></label>
                                        <v-text-field
                                            id="name"
                                            type="text"                                                
                                            label="{{ __('Name') }}"                                                
                                            name="name"
                                            value="{{ old('name') }}"                                                   
                                            required
                                                                                                
                                        ></v-text-field>                                      
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div> --}}


                                        <div>
                                            <label  class="d-none form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"></label>
                                            <v-text-field
                                                id="first_name"
                                                type="text"                                                
                                                label="{{ __('First Name') }}"                                                
                                                name="first_name"
                                                value="{{ old('first_name') }}"                                                   
                                                required
                                                                                                    
                                            ></v-text-field>                                      
                                            @if ($errors->has('first_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                                <label  class="d-none form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"></label>
                                                <v-text-field
                                                    id="last_name"
                                                    type="text"                                                
                                                    label="{{ __('Last Name') }}"                                                
                                                    name="last_name"
                                                    value="{{ old('last_name') }}"                                                   
                                                    required
                                                                                                        
                                                ></v-text-field>                                      
                                                @if ($errors->has('last_name'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('last_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>








                                    <div>
                                        <label  class="d-none form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"></label>
                                        <v-text-field
                                            id="email"
                                            type="email"                                                
                                            label="{{ __('E-Mail Address') }}"                                                
                                            name="email"
                                            value="{{ old('name') }}"                                                     
                                            required                                               
                                        ></v-text-field>                                      
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div> 
                                    <div>
                                        <label  class="d-none form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"></label>
                                        <v-text-field
                                            id="password"
                                            type="password"                                                
                                            label="{{ __('Password') }}"                                                
                                            name="password"                                                                                                        
                                            required                                               
                                        ></v-text-field>                                      
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div> 
                                    <div>
                                        <v-text-field
                                            id="password-confirm"
                                            type="password"                                                
                                            label="{{ __('Confirm Password') }}"                                                
                                            name="password_confirmation"                                                                                                    
                                            required                                               
                                        ></v-text-field>
                                    </div> 
                                    <div>
                                        <v-btn
                                            block
                                            color="success"
                                            type="submit"
                                            style="background-color: #4caf50; margin:8px 0"
                                        >
                                            <v-icon left >input</v-icon>
                                            {{ __('Register') }}          
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
