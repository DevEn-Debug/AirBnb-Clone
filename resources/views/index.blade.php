@extends('layouts.app')
@section('content')


<div class="jumbotron col-md-12 col-xs-12 ">
    <div class="division">
        <h1 class="title"><strong>Scegli la tua esperienza</strong></h1>
        <p class="text-center">Cambia quadro. Scopri alloggi nelle vicinanze <br> tutti da vivere, per lavoro o svago.</p>
        <div class="container h-100">
            <div class="d-flex justify-content-center h-100">
                <div class="searchbar">
                    <input id="address-input" class="search_input" type="text" name="" placeholder="Search...">
                    <a id="bottone" href="{{route('search')}}" class="search_icon"><i class="fas fa-search"></i></a>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- per creare la barretta verde "Appartamento Creato" --}}
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

{{-- appartement --}}
<div class="container" style="max-width: 1350px;">
    <div class="flats">
        <h1><strong><i class="far fa-heart"></i> Appartamenti in Evidenza <i class="far fa-heart"></i></strong></h1>
        <div class="row justify-content-center" style="margin:45px 0 ;">
            @php
            $count = 0;
            @endphp
            @foreach ($sponsors as $sponsor)
            @foreach ($sponsor -> flats as $flat)
            @if ($flat -> disactive == 0 && $flat -> deleted == 0 && $count< 6)
            @php
            $exist = isset($flat-> sponsors-> first()-> pivot-> flat_id);
            @endphp
            @if (!($exist))
            @elseif($date ->gt($flat-> sponsors-> first()-> pivot-> date_end))
            @else
              @php
              $count +=1;
              @endphp
              <div class="col-xs-12 col-lg-4 text-center" style="margin-bottom:20px;">
                  {{-- prima di richiamare l'img ricorda di eseguire artisan storage:link per creare un link simbolico
                          WARNING: ora la dir è accessibile anche da http://127.0.0.1:8000/storage/images/
                          Quindi occhio! --}}
                  <div class="dimension">
                      <a href="{{route('show', $flat -> id )}}"><img src="{{ asset($flat-> photo_url)}}" style="width: 100%;box-shadow: 0 0.3rem 1rem rgba(0, 0, 0, 0.35) !important; " alt="404 not found"></a>
                      <div class="shadow" style="background-color: #ffff;border-radius: 5px;border: solid 1px #343a40 ;position: absolute;top: 3%;left: 3%;width:100px;height:18px;">
                          <h6 style="color:#343a40 ;text-align: center;">SUPERHOST</h6>
                      </div>
                      <p style="margin-bottom: 1px;color: #f8fafc;position: absolute;bottom: 0px;left: 16px;font-size: 23px;"><strong>{{$flat -> price_at_night}} € </strong></p>
                  </div>

                  <div class="title-description">
                      <h2 style="font-size:16px;text-align: center;margin-top: 15px;}"><a href="{{route('show', $flat -> id )}}">{{$flat -> title}}</a></h2>

                  </div>
              </div>
            @endif
            @endif
            @endforeach
            @endforeach
        </div>
    </div>
</div>





@endsection
