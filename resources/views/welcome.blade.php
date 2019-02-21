<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- <script src="{{ asset('js/vendor/MooTools-Core-1.6.0.js') }}" defer></script> --}}
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="shortcut icon" href="{{ asset('../favicon.ico') }}" >
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <!--link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"-->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">   
</head>
<body>
    <div id="app" v-cloak>   
        <v-app>
            @include('layouts.toolbar')
            <v-content>            
                <v-container fluid>
                    <v-layout 
                        justify-center
                        align-center
                    >
                        <v-flex text-xs-center xs12 md10 lg8 xl6 mt-5 pt-5>                    
                            <!--v-carousel                            
                                delimiter-icon="$vuetify.icons.delimiter"
                                prev-icon="$vuetify.icons.prev"
                                next-icon="$vuetify.icons.next"
                            >
                                <v-carousel-item                             
                                    v-for="n in 3"
                                    :key="n"   
                                    :src="`img/templates/template${n}.jpg`"
                                    reverse-transition="fade"
                                    transition="fade"                                                 
                                ></v-carousel-item>                   
                            </v-carousel-->  
                            <h1>Welcome to Employees Schedule of AspireVapeCo</h1>               
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-container fluid>
                    <v-layout
                        justify-center
                        align-center 
                    >
                        <v-flex text-xs-center xs12 md10 lg8 xl6>
                            <v-card class="elevation-20" >                    
                               
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-content>
        </v-app>
    </div>
</body>
</html>
