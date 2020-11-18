<nav class="navbar navbar-expand-md navbar-light bg-white ">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="/img/Airbnb_Logo_Bélo.svg.png" alt="logo" width="180px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @endguest
                @auth

                <li class="nav-item dropdown">
                    @if (empty(Auth::user()->name))
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->email }}
                    </a>                        
                    @else
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>
                    @endif
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('profile')}} ">Account</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>

                @php
                $ishost = 0;
                @endphp

                @foreach ($flats as $flat)
                {{-- se l'user_id NON è vuoto e l'user_id del flat è ugale all'id dell'utente collegato e non è un host --}}
                @if ( !(empty($flat -> user_id)) && (($flat -> user_id) == (Auth::user()-> id)) && $ishost == 0 ) 
                @php
                $ishost = 1;
                @endphp
                @endif
                @endforeach


                @if ($ishost == 1)
                <a class="btn btn-primary " href="{{route('becomeHost')}}">Aggiungi Appartamento</a>
                @else
                <a class="btn btn-danger " href="{{route('becomeHost')}}">Diventa un Host</a>
                @endif


                @endauth

            </ul>
        </div>
    </div>
</nav>
