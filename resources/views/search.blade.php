@extends('layouts.app')
@section('content')

  <section style="padding: 25px 0; display: flex;justify-content: center;flex-direction: column;align-items: center;width:100%;background: rgb(131,58,180);background: linear-gradient(90deg, rgba(131,58,180,0.6671043417366946) 0%, rgba(253,29,29,0.7287289915966386) 50%, rgba(252,176,69,0.6502976190476191) 100%);">

    <div class="container h-100 barraRicercaInSearch">
        <div class="d-flex justify-content-center h-100">

            <div class="searchbar">
                <input id="address-input" class="search_input" type="text" name="" placeholder="Search...">
                <a id="bottone" href="{{route('search')}}" class="search_icon"><i class="fas fa-search"></i></a>
            </div>
        </div>
    </div>
    <h5 style="color:#ffff;">Seleziona il raggio di ricerca in km</h5>
    <div style="width: 40vw">
        <input type="range" class="custom-range" id="customRange11" min="0" max="250" value="20">
    </div>
    <span style="color:#ffff;font-size:16px;" class="font-weight-bold  ml-2 valueSpan2"></span>
</section>
  <div class="d-flex" id="wrapper">

      <!-- Sidebar -->
      <div class="bg-light border-right" id="sidebar-wrapper" style="position:relative">

        <div class="servizi-check" style="position:relative; ">
            <ul class="ks-cboxtags">
                @foreach ($services as $service)
                <li style="display:block;"><input type="checkbox" id="{{$service -> service_name}}" name="service[]" class="form-check-input" id="{{$service -> id}}" value="{{$service -> id}}" rel="{{$service -> service_name}}">
                    <label style="width: 95%;" class="form-check-label" for="{{$service -> service_name}}">{{$service-> service_name}} </label>
                </li>
                @endforeach
            </ul>
            <ul>
            <li style="display:inline-block;">
            <select id="nofbed" style="display:inline-block;max-width:100%;border-radius:0px;margin: 5px 6px;border: 2px solid #ccc;border-radius: 30px;padding: 9px;" name="number_of_bed">
              {{-- for per i letti --}}  
              @for ($i = 1; $i <= 15; $i++) <option value="{{$i}}">{{$i}} letti</option>
                    @endfor
            </select></li>
            <li style="display:inline-block;">
            <select id="nofroom" style="display:inline-block;max-width:87%;border-radius:0px;margin: 5px 6px;border: 2px solid #ccc;border-radius: 30px;padding: 9px;" name="number_of_room">
              {{-- for per le stanze --}}
                @for ($i = 1; $i <= 15; $i++) <option value="{{$i}}">{{$i}} stanze</option>
                    @endfor
            </select></li></ul>
            <button style="position:absolute;left: 7px;width: 130px;" type="button" id="search-button" class="btn btn-primary btn-sm float-right">Filtra</button>
        </div>
        <button  class="btn filter-button btn-dark" id="menu-toggle"><i class="fas fa-angle-right"></i> Filters</button>
      </div>
      <!-- /#sidebar-wrapper -->

      <!-- Page Content -->
      <div id="page-content-wrapper">
      <div class="container">
        {{-- verifica dei COOKIE con dati presi dal controller--}}
        @if ($city == '')
        <h1 style="margin-top: 70px ;text-align:center;">Tutti i nostri appartamenti</h1>
        @else
        <h1 style="margin-top: 70px ;text-align:center;">Appartamenti a {{$city}}</h1>
        @endif
        <p id="message" class="none text-center">Non ci sono risultati corrispondenti</p>
        <div class="row flatsss-row">

          {{-- prendo ogni flat sponsorizzatto dalla variabile nel Controller --}}
          @foreach ($flatsSponsor as $flat)
          @php
          $exist = isset($flat-> sponsors-> first()-> pivot-> flat_id);
          @endphp
          @if (!($exist))
          {{-- se lo sponsor NON è scaduto --}}
          @elseif($date ->lt($flat-> sponsors-> first()-> pivot-> date_end))

              @php
               $lat = floatval($flat-> latitude);
               $long = floatval($flat-> longitude);
               $latitude = floatval($latitude);
               $longitude = floatval($longitude);
               if ($latitude != 0) {
                 //    calcolo della distanta tra 2 punti data la lat e long
                 $dist = (3958*3.1415926*sqrt(($lat-$latitude)*($lat-$latitude) + cos($lat/57.29578)*cos($latitude/57.29578)*($long-$longitude)*($long-$longitude))/180);
               } else {
                 //    se l'input i ricerca è vuoto allora viene impostato un dato di default
                 $dist = 0;
               }
              @endphp
              {{-- se ladistanza risultante dal calcolo precedente è minore del filtro di raggio impostato --}}
              @if ($dist < $distance)
                @if ($flat -> disactive == 0 && $flat -> deleted == 0)

                  <a href="{{route('show', $flat -> id)}}">
                      <div class="col-xs-12 col-md-6 col-lg-4 blocco-flat" data-id="{{$flat -> id}}" style="height: 100%;">
                          <div id="carouselExampleControls{{$flat -> id}}" class="carousel slide" data-interval="false" style="position: relative;border-radius:10px; margin-bottom: 10px;">
                              <div class="carousel-inner " style="border-radius: 10px;box-shadow: 0 0.3rem 1rem rgba(0, 0, 0, 0.35) !important;">
                                  <div class="carousel-item active">
                                      <img src=" {{asset($flat -> photo_url)}}" alt="">
                                  </div>
                                  @php
                                    $i = 0 ;
                                  @endphp
                                  @foreach ($photos as $photo)
                                  @if ($photo -> flat_id == $flat -> id)
                                    <div class="carousel-item" >
                                    <img src=" {{asset($photo -> photo_url)}}" alt="">
                                    </div>
                                    @php
                                      $i = 1 ;
                                    @endphp
                                  @endif
                                  @endforeach



                              {{-- uguale a sopra --}}
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
                              <p style="margin-bottom: 1px;color: #f8fafc;position: absolute;bottom: 0px;left: 11px;font-size: 21px;"><strong>{{$flat -> price_at_night}} € </strong></p>
                              <div class="shadow" style="background-color: #ffff;border-radius: 5px;border: solid 1px #343a40 ;position: absolute;top: 3%;left: 3%;width:100px;height:18px;">
                                  <h6 style="color:#343a40 ;text-align: center;">SUPERHOST</h6>
                              </div>
                          </div>
                  </a>
                  <h4 class="titoloappsearch">{{$flat -> title}}</h4>
                  <p class="descrizione">{{$flat -> description}}</p>
              </div>

                @endif
              @endif

          @else

          @endif
          @endforeach

          @foreach ($flatsSponsor as $flat)
          @php
          $exist = isset($flat-> sponsors-> first()-> pivot-> flat_id);
          @endphp
          @if (!($exist))
          @elseif($date ->lt($flat-> sponsors-> first()-> pivot-> date_end))

          @else

          {{-- passato l'else prende solo gli sponsor Scaduti, il resto è uguale a sopra --}}

              @php
               $lat = floatval($flat-> latitude);
               $long = floatval($flat-> longitude);
               $latitude = floatval($latitude);
               $longitude = floatval($longitude);
               if ($latitude != 0) {
                 $dist = (3958*3.1415926*sqrt(($lat-$latitude)*($lat-$latitude) + cos($lat/57.29578)*cos($latitude/57.29578)*($long-$longitude)*($long-$longitude))/180);
               } else {
                 $dist = 0;
               }
              @endphp
              @if ($dist < $distance)
                @if ($flat -> disactive == 0 && $flat -> deleted == 0)

                  <a href="{{route('show', $flat -> id)}}">
                      <div class="col-xs-12 col-md-6 col-lg-4 blocco-flat" data-id="{{$flat -> id}}" style="height: 100%;">
                          <div id="carouselExampleControls{{$flat -> id}}" class="carousel slide" data-interval="false" style="position: relative;border-radius:10px; margin-bottom: 10px;">
                              <div class="carousel-inner " style="border-radius: 10px;box-shadow: 0 0.3rem 1rem rgba(0, 0, 0, 0.35) !important;">
                                  <div class="carousel-item active">
                                      <img src=" {{asset($flat -> photo_url)}}" alt="">
                                  </div>
                                  @php
                                    $i = 0 ;
                                  @endphp
                                  @foreach ($photos as $photo)
                                  @if ($photo -> flat_id == $flat -> id)
                                    <div class="carousel-item" >
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
                              <p style="margin-bottom: 1px;color: #f8fafc;position: absolute;bottom: 0px;left: 11px;font-size: 21px;"><strong>{{$flat -> price_at_night}} € </strong></p>
                          </div>
                  </a>
                  <h4 class="titoloappsearch">{{$flat -> title}}</h4>
                  <p class="descrizione">{{$flat -> description}}</p>
              </div>

                @endif
              @endif

          @endif
          @endforeach

              {{-- prende solo quelli NON sponsorizzati e li stampo con lo stesso sistema--}}
            @foreach ($flatsNoSponsor as $flat)
              @php
              $lat = floatval($flat-> latitude);
              $long = floatval($flat-> longitude);
              $latitude = floatval($latitude);
              $longitude = floatval($longitude);
              if ($latitude != 0) {
                $dist = (3958*3.1415926*sqrt(($lat-$latitude)*($lat-$latitude) + cos($lat/57.29578)*cos($latitude/57.29578)*($long-$longitude)*($long-$longitude))/180);
              } else {
                $dist = 0;
              }


              @endphp
              @if ($dist < $distance)
                @if ($flat -> disactive == 0 && $flat -> deleted == 0)
                <a href="{{route('show', $flat -> id)}}">
                    <div class="col-xs-12 col-md-6 col-lg-4 blocco-flat" data-id="{{$flat -> id}}" style="height: 100%;">
                        <div id="carouselExampleControls{{$flat -> id}}" class="carousel slide" data-interval="false" style="border-radius:10px; margin-bottom: 10px;">
                            <div class="carousel-inner " style="border-radius: 10px;box-shadow: 0 0.3rem 1rem rgba(0, 0, 0, 0.35) !important;">
                                <div class="carousel-item active">
                                    <img src=" {{asset($flat -> photo_url)}}" alt="">
                                </div>
                                @php
                                  $i = 0 ;
                                @endphp
                                @foreach ($photos as $photo)
                                @if ($photo -> flat_id == $flat -> id)
                                  <div class="carousel-item" >
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
                            <p style="margin-bottom: 1px;color: #f8fafc;position: absolute;bottom: 0px;left: 11px;font-size: 21px;"><strong>{{$flat -> price_at_night}} € </strong></p>
                        </div>
                </a>

                <h4 class="titoloappsearch">{{$flat -> title}}</h4>
                <p class="descrizione">{{$flat -> description}}</p>
            </div>
            @endif
            @endif

            @endforeach
      </div>
      </div>
      </div>
      <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->




@endsection
