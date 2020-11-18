@extends('layouts.app')

@section('content')
<div style="width: 100%;height: 15px;background: rgb(131,58,180);background: linear-gradient(90deg, rgba(131,58,180,0.6671043417366946) 0%, rgba(253,29,29,0.7287289915966386) 50%, rgba(252,176,69,0.6502976190476191) 100%);"></div>
<div class="container">
    <div class="row justify-content-center" style="padding: 30px 0;">
        <div class="col-md-12">
            <div>
                <h1 style="padding-bottom: 15px;">Account</h1>
                @if (isset(Auth::user()->name))
                  <p><strong>Nome</strong> {{Auth::user()->name}} </p>
                @endif
                @if (isset(Auth::user()->lastname))
                  <p><strong>Cognome</strong> {{Auth::user()->lastname}} </p>
                @endif
                @if (isset(Auth::user()->date_of_birth))
                  <p><strong>Data di nascita</strong> {{Auth::user()->date_of_birth}} </p>
                @endif
                <p><strong>Email</strong> {{Auth::user()->email}} </p>
            </div>
        </div>
    </div>

    <div style="width: 100%;height: 2px;margin-bottom: 60px;background: rgb(131,58,180);background: linear-gradient(90deg, rgba(131,58,180,0.6671043417366946) 0%, rgba(253,29,29,0.7287289915966386) 50%, rgba(252,176,69,0.6502976190476191) 100%);">
    </div>
    <ul>
        @php
        $ishost = 0;
        @endphp
        @foreach ($flats as $flat)
        @if ( !(empty($flat -> user_id)) && (($flat -> user_id) == (Auth::user()-> id)) && $ishost == 0 )
        @php
        $ishost = 1;
        @endphp
        @endif
        @endforeach

        @if ($ishost == 1)
        <h1>I tuoi appartamenti :</h1>
        @else

        @endif




        @foreach ($flats as $flat)
        @if ((($flat-> user_id) == (Auth::user()->id)) && $flat -> deleted == 0)
        <div class="row justify-content-center" style="margin-bottom: 23px;">
            <a href="{{route('show', $flat -> id )}}">
                <div class="col-xs-12 col-md-4 blocco-flat" style="position:relative;">
                    <div id="carouselExampleControls{{$flat -> id}}" class="carousel slide" data-interval="false" style="border-radius:10px; margin-bottom: 10px;">
                        <div class="carousel-inner">

                            <div class="carousel-item active" style="height: 250px;">
                                <img src=" {{asset($flat -> photo_url)}}" alt="">
                            </div>

                              @php
                                $i = 0 ;
                              @endphp
                              @foreach ($photos as $photo)
                              @if ($photo -> flat_id == $flat -> id)
                                <div class="carousel-item" style="height: 250px;">
                                <img src=" {{asset($photo -> photo_url)}}" alt="">
                                </div>
                                @php
                                  $i = 1 ;
                                @endphp
                              @endif
                              @endforeach


                        </div>
                        @if ($i == 1)
                          <a class="carousel-control-prev" href="#carouselExampleControls{{$flat -> id}}" role="button" data-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#carouselExampleControls{{$flat -> id}}" role="button" data-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="sr-only">Next</span>
                          </a>
                        @endif

                        @php
                        // controllare sempre se esiste contenuto nella tabella ponte prima di eseguire il pivot
                        $exist = isset($flat-> sponsors-> first()-> pivot-> flat_id);
                        @endphp
                        @if (!($exist))
                        @elseif($date ->gt($flat-> sponsors-> first()-> pivot-> date_end))
                        @else
                        <div class="shadow" style="background-color: #ffff;border-radius: 5px;border: solid 1px #343a40 ;position: absolute;top: 13px;left: 13px;width:109px;height:25px;">
                            <p style="color: black;text-align:center;">Sponsorizzato</p>
                        </div>
                        @endif
                        @if ($i == 0)
                          <a style="position: absolute;top: 7px;right: 14px;font-size: 30px;color: #fff;"href="{{route('photo', $flat -> id)}}"><i class="fas fa-images"></i></a>
                        @endif
                    </div>
                </div>
            </a>

            <div class="col-xs-12 col-md-4 " style="display: flex; align-items: center;">
                <div>
                    <a href="{{route('show', $flat -> id )}}">
                        <h4 style=" margin-bottom: 10px;" class="titoloappsearch">{{$flat -> title}}</h4>
                    </a>
                    <p class="descrizione">{{$flat -> description}}</p>
                    <p><strong>{{$flat -> price_at_night}} €</strong></p>
                </div>
            </div>
            <div class="col-xs-12 col-md-4 " style="text-align: end;">
                <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%;">
                    @php
                    $exist = isset($flat-> sponsors-> first()-> pivot-> flat_id);
                    @endphp
                    @if (!($exist))
                    <div class="width">
                        <a href="{{route('sponsorForm', $flat-> id)}}">Sponsorizza<i class="fas fa-chart-line"></i></a>

                    </div>
                    @elseif($date ->gt($flat-> sponsors-> first()-> pivot-> date_end))
                    <div class="width">
                        <a href="{{route('sponsorFormUpdate', $flat-> id)}}">Sponsorizza<i class="fas fa-chart-line"></i></a>
                    </div>
                    @else
                    @endif
                    <div class="width">
                        <a href="{{route('showStats', $flat-> id)}}">Statistiche<i class="fas fa-chart-bar"></i></a>

                    </div>
                    <div class="width">
                        <a href="{{route('message', $flat -> id)}}">Messaggi<i class="fas fa-envelope"></i></a>

                    </div>
                    <div class="width">
                        <a href="{{route('update', $flat -> id)}}">Modifica<i class="fas fa-pen"></i></a>

                    </div>
                    @if ($flat -> disactive == 0)
                    <div class="width">
                        <a href="{{route('disable', $flat -> id)}}">Disabilita<i class="fas fa-check-square"></i></a>

                    </div>
                    @else
                    <div class="width">
                        <a href="{{route('enable', $flat -> id)}}">Abilita<i class="fas fa-check-square"></i></a>

                    </div>
                    @endif
                    <div class="width">
                        <a href="{{route('delete', $flat -> id)}}">Elimina<i class="fas fa-trash-alt"></i></a>

                    </div>
                </div>
            </div>
        </div>
        <div style="width: 100%;height: 2px;background: rgb(131,58,180);background: linear-gradient(90deg, rgba(131,58,180,0.6671043417366946) 0%, rgba(253,29,29,0.7287289915966386) 50%, rgba(252,176,69,0.6502976190476191) 100%);"></div>
        @endif
        @endforeach
    </ul>
</div>
@endsection
