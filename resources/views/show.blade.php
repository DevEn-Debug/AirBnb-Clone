@extends('layouts.app')
@section('content')

<div style="width: 100%;height: 15px;background: rgb(131,58,180);background: linear-gradient(90deg, rgba(131,58,180,0.6671043417366946) 0%, rgba(253,29,29,0.7287289915966386) 50%, rgba(252,176,69,0.6502976190476191) 100%); margin-bottom: 20px;">

</div>
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

{{-- inizio carousel --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-12">
            <h1 style="margin-top:15px;">{{$flat -> title}}</h1>
            <a href="{{route('show', $flat -> id)}}">
                <div id="carouselExampleControls" class="carousel slide" data-interval="false">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img style="max-height:740px;" class="d-block w-100" src="{{ asset($flat-> photo_url)}}" alt="First slide">
                        </div>
                        @php
                          $i = 0 ;
                        @endphp
                        @foreach ($photos as $photo)
                        @if ($photo -> flat_id == $flat -> id)
                          <div class="carousel-item" >
                          <img style="max-height:740px;" class="d-block w-100" src=" {{asset($photo -> photo_url)}}" alt="">
                          </div>
                          @php
                            $i = 1 ;
                          @endphp
                        @endif
                        @endforeach

                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </a>
        </div>
    </div>
        {{-- fine carousel --}}

    {{-- parte di descrizione appartamento --}}
    <div class="container carousel" style="background-color : rgba(255, 99, 132, 0)">
        <div class="row justify-content-center">
            @auth
            {{-- cambio di layout in base al tipo di utente (Host - User - Guest) --}}
            {{-- se sei Guest vedi il form + email --}}
            {{-- se sei User/Host non proprietario, vedi form ma non l'email --}}
            {{-- se sei il proprietario non mostra il form --}}
            @if (($flat-> user_id) == (Auth::user()->id))
            <div class="col-xs-12">

                <h2 style="margin-top: 28px;">{{$flat -> type}} di {{$flat -> user -> name}}</h2>
                <h5>{{$flat -> number_of_bed}} ospiti · {{$flat -> number_of_room}} camere · {{$flat -> number_of_bed}} letti · {{$flat -> number_of_bathroom}} bagno · {{$flat -> mq}}mq</h5>

                <div class="divisore"></div>
                <div class="row">
                    <div class="col-md-1 logo">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>Address</h4>
                        <h5>{{$flat -> address}}</h5>
                    </div>
                    <div class="col-md-1 logo">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>{{$flat -> type}}</h4>
                        <h5>sarà a tua completa disposizione.</h5>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1 logo">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>Self check-in</h4>
                        <h5>
                            Esegui autonomamente il check-in usando la cassetta di sicurezza.</h5>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1 logo">
                        <i class="fas fa-key"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>Pulito e ordinato</h4>
                        <h5>
                            11 ospiti recenti hanno affermato che questo alloggio ha una pulizia impeccabile.</h5>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1 logo">
                        <i class="fas fa-window-close"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>Termini di cancellazione</h4>
                        <h5>
                            Cancella la prenotazione prima delle ore 12:00 PM del 24 ott e riceverai un rimborso completo.
                            Scopri i dettagli</h5>

                    </div>
                </div>
                <div class="divisore"></div>


                @foreach ($flat -> services as $service)
                <div class="row">
                    <div class="col-md-1 logo">
                        <i class="{{$service -> icon}}"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>{{$service -> service_name}}</h4>
                    </div>
                </div>
                @endforeach
                @if (!(empty($flat-> services -> first() ->pivot-> flat_id)))
                <div class="divisore"></div>
                @endif


                <div class="row">
                    <div class="col-md-12">
                        <h2>Descrizione</h2>
                        <h5 style="margin-bottom: 40px;">{{$flat -> description}}</h5>
                    </div>
                </div>


            </div>
            @else
            <div class="col-xs-12 col-md-8">

                <h2 style="margin-top: 28px;">{{$flat -> type}} di {{$flat -> user -> name}}</h2>
                <h5>{{$flat -> number_of_bed}} ospiti · {{$flat -> number_of_room}} camere · {{$flat -> number_of_bed}} letti · {{$flat -> number_of_bathroom}} bagno · {{$flat -> mq}}mq</h5>

                <div class="divisore"></div>
                <div class="row">
                    <div class="col-md-1 logo">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>Address</h4>
                        <h5>{{$flat -> address}}</h5>
                    </div>
                    <div class="col-md-1 logo">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>{{$flat -> type}}</h4>
                        <h5>sarà a tua completa disposizione.</h5>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1 logo">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>Self check-in</h4>
                        <h5>
                            Esegui autonomamente il check-in usando la cassetta di sicurezza.</h5>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1 logo">
                        <i class="fas fa-key"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>Pulito e ordinato</h4>
                        <h5>
                            11 ospiti recenti hanno affermato che questo alloggio ha una pulizia impeccabile.</h5>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1 logo">
                        <i class="fas fa-window-close"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>Termini di cancellazione</h4>
                        <h5>
                            Cancella la prenotazione prima delle ore 12:00 PM del 24 ott e riceverai un rimborso completo.
                            Scopri i dettagli</h5>

                    </div>
                </div>
                <div class="divisore"></div>


                @foreach ($flat -> services as $service)
                <div class="row">
                    <div class="col-md-1 logo">
                        <i class="{{$service -> icon}}"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>{{$service -> service_name}}</h4>
                    </div>
                </div>
                @endforeach
                @if (!(empty($flat-> services -> first() ->pivot-> flat_id)))
                <div class="divisore"></div>
                @endif


                <div class="row">
                    <div class="col-md-12">
                        <h2>Descrizione</h2>
                        <h5 style="margin-bottom: 40px;">{{$flat -> description}}</h5>
                    </div>
                </div>

            </div>
            @endif
            @endauth
            @guest
            <div class="col-xs-12 col-md-8">

                <h2 style="margin-top: 28px;">{{$flat -> type}} di {{$flat -> user -> name}}</h2>
                <h5>{{$flat -> number_of_bed}} ospiti · {{$flat -> number_of_room}} camere · {{$flat -> number_of_bed}} letti · {{$flat -> number_of_bathroom}} bagno · {{$flat -> mq}}mq</h5>

                <div class="divisore"></div>
                <div class="row">
                    <div class="col-md-1 logo">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>Address</h4>
                        <h5>{{$flat -> address}}</h5>
                    </div>
                    <div class="col-md-1 logo">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>{{$flat -> type}}</h4>
                        <h5>sarà a tua completa disposizione.</h5>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1 logo">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>Self check-in</h4>
                        <h5>
                            Esegui autonomamente il check-in usando la cassetta di sicurezza.</h5>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1 logo">
                        <i class="fas fa-key"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>Pulito e ordinato</h4>
                        <h5>
                            11 ospiti recenti hanno affermato che questo alloggio ha una pulizia impeccabile.</h5>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1 logo">
                        <i class="fas fa-window-close"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>Termini di cancellazione</h4>
                        <h5>
                            Cancella la prenotazione prima delle ore 12:00 PM del 24 ott e riceverai un rimborso completo.
                            Scopri i dettagli</h5>

                    </div>
                </div>
                <div class="divisore"></div>


                @foreach ($flat -> services as $service)
                <div class="row">
                    <div class="col-md-1 logo">
                        <i class="{{$service -> icon}}"></i>
                    </div>
                    <div class="col-md-11 scritte">
                        <h4>{{$service -> service_name}}</h4>
                    </div>
                </div>
                @endforeach
                @if (!(empty($flat-> services -> first() ->pivot-> flat_id)))
                <div class="divisore"></div>
                @endif


                <div class="row">
                    <div class="col-md-12">
                        <h2>Descrizione</h2>
                        <h5 style="margin-bottom: 40px;">{{$flat -> description}}</h5>
                    </div>
                </div>

            </div>
            @endguest
            <div class="col-xs-12 col-md-4">
                @auth
                @if (($flat-> user_id) != (Auth::user()->id))
                <div class="col-xs-12 col-md-12 messaggio">
                    <form action="{{route('storeMessagesUser', $flat-> id)}}" method="post">
                        @csrf
                        @method('POST')
                        <h1>Scrivici</h1>
                        <div class="form-group">
                            <label for="name">Nome e Cognome</label>
                            <input type="text" id="fname" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nome e cognome">
                            @error('name')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{$message}} </strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">

                            <label for="subject">Oggetto</label>
                            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Oggetto">
                            @error('subject')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{$message}} </strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">

                            <label for="message">Messaggio</label>
                            <textarea id="subject" name="message" class="form-control @error('message') is-invalid @enderror" placeholder="Il tuo messaggio.." style="height:270px"></textarea>
                            @error('message')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{$message}} </strong>
                            </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Invia</button>
                    </form>
                </div>
                @endif
                @endauth

                @guest
                <div class="col-xs-12 col-md-12 messaggio">
                    <form action="{{route('storeMessagesGuest',$flat -> id)}}" method="post">
                        @csrf
                        @method('POST')
                        <h1>Scrivici</h1>
                        <div class="form-group">
                            <label for="name">Nome e Cognome</label>
                            <input type="text" id="fname" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nome e cognome">
                            @error('name')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{$message}} </strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email..">
                            @error('email')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{$message}} </strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="subject">Oggetto</label>
                            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Oggetto">
                            @error('subject')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{$message}} </strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="message">Messaggio</label>
                            <textarea id="subject" name="message" class="form-control @error('message') is-invalid @enderror" placeholder="Il tuo messaggio.." style="height:270px"></textarea>
                            @error('message')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{$message}} </strong>
                            </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success btn-block">Invia</button>
                    </form>
                </div>
                @endguest

            </div>


        </div>


    </div>


    <p id="la" class="none">{{$flat -> latitude}}</p>
    <p id="lo" class="none">{{$flat -> longitude}}</p>
    <div class="row">
        <div class="col-xs-12 col-md-12 text-center">
            <div id="map" style="border: 1px solid black ; width: 100%; height: 500px;"></div>
        </div>
    </div>





</div>









@endsection
