@extends('layouts.app')

@section('content')
<div style="width: 100%;height: 15px;background: rgb(131,58,180);background: linear-gradient(90deg, rgba(131,58,180,0.6671043417366946) 0%, rgba(253,29,29,0.7287289915966386) 50%, rgba(252,176,69,0.6502976190476191) 100%);"></div>
<div class="container">
    <div class="row justify-content-center">
        <a href="{{route('show', $flat -> id )}}">
            <div class="col-xs-12 col-md-6 blocco-flat" style="position:relative;height: 400px;margin-bottom: 60px;">
                <div id="carouselExampleControls{{$flat -> id}}" class="carousel slide" data-interval="false" style="border-radius:10px; margin-bottom: 10px;">
                    <div class="carousel-inner">
                        <div class="carousel-item active" style="height: 350px;">
                            <img src=" {{asset($flat -> photo_url)}}" alt="">
                        </div>
                        @php
                          $i = 0 ;
                        @endphp
                        @foreach ($photos as $photo)
                        @if ($photo -> flat_id == $flat -> id)
                          <div class="carousel-item" style="height: 350px;">
                          <img src=" {{asset($photo -> photo_url)}}" alt="">
                          </div>
                          @php
                            $i = 1 ;
                          @endphp
                        @endif
                        @endforeach


                  </div>

                    <a class="carousel-control-prev" href="#carouselExampleControls{{$flat -> id}}" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls{{$flat -> id}}" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
            
                </div>
            </div>
        </a>
        <div class="col-xs-12 col-md-6 " style="display: flex; align-items: center;">
            <div>
                <h4 style=" margin-bottom: 10px;" class="titoloappsearch">{{$flat -> title}}</h4>
                <p class="descrizione">{{$flat -> description}}</p>
                <p><strong>{{$flat -> price_at_night}} €</strong></p>
            </div>
        </div>

        <div
          style="width: 100%;height: 2px;margin-bottom: 60px;background: rgb(131,58,180);background: linear-gradient(90deg, rgba(131,58,180,0.6671043417366946) 0%, rgba(253,29,29,0.7287289915966386) 50%, rgba(252,176,69,0.6502976190476191) 100%);">
        </div>
    </div>
    <h1 style="margin-bottom: 100px;">I messaggi dell' Appartamento:</h1>
    <ul>

        @foreach ($messages as $message)
        @if ($message -> flat_id == $flat -> id)
        <div class="row justify-content-center" style="margin: 20px;">
            <div class="col-xs-12 " style="width:100%;word-wrap:break-word;">
                <p><strong>Nome Cognome :</strong>{{$message -> name}}</p>
            </div>
            <div class="col-xs-12 " style="width:100%;word-wrap:break-word;">
                <p><strong>Email :</strong>{{$message -> email}}</p>
            </div>
            <div class="col-xs-12 " style="width:100%;word-wrap:break-word;">
                <p><strong>Subject :</strong>{{$message -> subject}}</p>
            </div>
            <div class="col-xs-12 " style="width:100%;word-wrap:break-word;">
                <p><strong>Message :</strong>{{$message -> message}}</p>
            </div>
        </div>
        <div style="width: 100%;height: 2px;background: rgb(131,58,180);background: linear-gradient(90deg, rgba(131,58,180,0.6671043417366946) 0%, rgba(253,29,29,0.7287289915966386) 50%, rgba(252,176,69,0.6502976190476191) 100%);"></div>
        @endif
        @endforeach
    </ul>
</div>
@endsection
