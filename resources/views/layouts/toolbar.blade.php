<v-card v-cloak>     
    <v-toolbar color="#43A047" height="40">
        <v-toolbar-title id="es_logo">
            @if (Request::is('admin') || Request::is('admin/stat'))
                <v-btn flat class="link-href tab-link-href" color="white" href="{{ url('admin') }}">                       
                    <img 
                        src="{{asset('/img/icons/main_icon.png')}}" 
                        height="30"                           
                    >                            
                    &nbsp;
                    <span class="hidden-sm-and-down">Employees Schedule</span>
                </v-btn>
            @else
                <v-btn flat class="link-href tab-link-href" color="black" href="{{ url('employee') }}">                       
                    {{-- <img 
                        src="{{asset('/img/icons/main_icon.png')}}" 
                        height="30"                           
                    >                             --}}
                    &nbsp;
                    <span class="hidden-sm-and-down">Employees Schedule</span>
                </v-btn>
            @endif
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
            @guest               
                <v-btn flat color="black" class="link-href" href="{{ route('login') }}">
                    <v-icon color="black" dark>input</v-icon>
                    &#8239;
                    {{ __('Login') }}
                </v-btn>
                @if (Route::has('register') && Request::is('admin/login'))
                    <v-btn flat color="black" class="link-href" href="{{ route('register') }}">
                        <v-icon color="black" dark>how_to_reg</v-icon>
                        &#8239;
                        {{ __('Register') }}
                    </v-btn>
                @endif
            @else
                @if(Request::is('employee') || Request::is('employee/*'))    
                    <v-menu
                        transition="slide-x-transition"
                        bottom
                        right                    
                    >
                        <v-btn
                            slot="activator"
                            dark 
                            flat
                        >
                            <v-icon pa-4>account_circle</v-icon>
                            &nbsp;
                            <a pa-4 class="black--text">{{ Auth::user()->first_name }}</a>
                        </v-btn>            
                        <v-list class="green darken-1">
                            <v-list-tile>
                                <v-list-tile-title>
                                    <span class="white--text">First Name:</span> 
                                    {{ Auth::user()->first_name }}
                                </v-list-tile-title>
                            </v-list-tile>
                            <v-list-tile>
                                <v-list-tile-title>
                                    <span class="white--text">Last Name:</span> 
                                    {{ Auth::user()->last_name }}
                                </v-list-tile-title>
                            </v-list-tile>
                            <v-list-tile>                            
                                <v-list-tile-title>
                                    <span class="white--text">Email:</span> 
                                    {{ Auth::user()->email }}
                                </v-list-tile-title>
                            </v-list-tile>
                        </v-list>
                    </v-menu>
                @else 
                    <v-btn disabled dark flat>
                        <v-icon pa-4>account_circle</v-icon>
                        &nbsp;
                        <a pa-4 class="black--text">{{ Auth::user()->first_name }}</a>     
                    </v-btn>   
                @endif
                <v-btn 
                    flat 
                    color="black" 
                    class="link-href" 
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                >
                    <v-icon color="black">exit_to_app</v-icon>
                    &#8239;
                    &nbsp;
                    {{ __('Logout') }}
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </v-btn>
            @endguest
        </v-toolbar-items>
    </v-toolbar>    
    {{-- @if (Request::is('admin') || Request::is('admin/stat') || Request::is('admin/stor') || Request::is('admin/cache')) --}}
    @if(Request::is('employee') || Request::is('employee/tasks') || Request::is('employee/tasks/*') || Request::is('employee/tasks/edit/*') || Request::is('employee/account'))
        <etoolbar url="{{ url('/') }}"></etoolbar>
    @elseif(Request::is('admin') || Request::is('admin/users') || Request::is('admin/schedule'))
        <atoolbar url="{{ url('/') }}"></atoolbar>
    @endif
</v-card>
