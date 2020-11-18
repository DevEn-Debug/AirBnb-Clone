@extends('layouts.app')

@section('content')
<div style="width: 100%;height: 15px;background: rgb(131,58,180);background: linear-gradient(90deg, rgba(131,58,180,0.6671043417366946) 0%, rgba(253,29,29,0.7287289915966386) 50%, rgba(252,176,69,0.6502976190476191) 100%);"></div>
<div class="container">
    <div class="row justify-content-center" style="padding : 60px 0;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"
                  style="text-align:center; color:#ffff; font-weight:bold background: rgb(131,58,180);background: linear-gradient(90deg, rgba(131,58,180,0.6671043417366946) 0%, rgba(253,29,29,0.7287289915966386) 50%, rgba(252,176,69,0.6502976190476191) 100%);">
                    Inserisci il tuo appartamento.</div>


                <div class="card-body">
                    <form action="{{route('editFlat', $flat -> id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="title">Titolo</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{$flat -> title}}" ondblclick="this.value=''">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}} </strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type">Tipo</label>
                            <select class="form-control" name="type">
                                <option value="Intero Appartamento">Intero Appartamento</option>
                                <option value="Singola Stanza">Singola Stanza</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Descrizione</label>
                            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{$flat -> description}}" ondblclick="this.value=''">
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}} </strong>
                            </span>
                            @enderror
                        </div>

                <div class="form-group" style="padding-top:1rem;">
                    <label for="price_at_night">Prezzo a notte</label>
                    <input type="number" name="price_at_night" class="form-control @error('price_at_night') is-invalid @enderror" value="{{$flat -> price_at_night}}" ondblclick="this.value=''">
                    @error('price_at_night')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}} </strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="number_of_bed">Numero di letti</label>
                    <select class="form-control" name="number_of_bed">
                        @for ($i = 1; $i <= 15; $i++) <option value="{{$i}}">{{$i}}</option>
                            @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label for="number_of_bathroom">Numero di Bagni</label>
                    <select class="form-control" name="number_of_bathroom">
                        @for ($i = 1; $i <= 15; $i++) <option value="{{$i}}">{{$i}}</option>
                            @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label for="number_of_room">Numero di stanze</label>
                    <select class="form-control" name="number_of_room">
                        @for ($i = 1; $i <= 15; $i++) <option value="{{$i}}">{{$i}}</option>
                            @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label for="mq">Metri quadrati</label>
                    <input type="number" name="mq" class="form-control @error('mq') is-invalid @enderror" value="{{$flat -> mq}}" ondblclick="this.value=''">
                    @error('mq')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}} </strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="photo_url">Carica la tua immagine di copertina</label>
                    <input type="file" name="photo_url" class="form-control @error('photo_url') is-invalid @enderror" value="{{$flat -> photo_url}}" ondblclick="this.value=''">
                    @error('photo_url')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}} </strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Indirizzo</label>
                    <input id="addresshost" type="text" name="address" class="search_input form-control @error('address') is-invalid @enderror" value="{{old('address')}}" placeholder="Search...">

                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}} </strong>
                    </span>
                    @enderror
                </div>



                <input id="latitude" type="text" name="latitude" class="form-control none" value="" ondblclick="this.value=''">
                <input id="longitude" type="text" name="longitude" class="form-control none" value="" ondblclick="this.value=''">
                <button type="submit" class="btn btn-success btn-block">Inserisci il tuo Appartamento</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
