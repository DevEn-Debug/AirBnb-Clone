@extends('layouts.app')

@section('content')
<div style="width: 100%;height: 15px;background: rgb(131,58,180);background: linear-gradient(90deg, rgba(131,58,180,0.6671043417366946) 0%, rgba(253,29,29,0.7287289915966386) 50%, rgba(252,176,69,0.6502976190476191) 100%);"></div>
<div class="container">
    <div class="row justify-content-center" style="padding : 60px 0;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"
                  style="text-align:center; color:#ffff; font-weight:bold background: rgb(131,58,180);background: linear-gradient(90deg, rgba(131,58,180,0.6671043417366946) 0%, rgba(253,29,29,0.7287289915966386) 50%, rgba(252,176,69,0.6502976190476191) 100%);">
                    Carica</div>


                <div class="card-body">
                    <form action="{{route('storePhoto', $flat -> id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')


                <div class="form-group">
                    <label for="photo_url">Carica immagine </label>
                    <input type="file" name="photo_url" class="form-control @error('photo_url') is-invalid @enderror" value="{{$flat -> photo_url}}" ondblclick="this.value=''">
                    @error('photo_url')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}} </strong>
                    </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success btn-block">Inserisci Immagini</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
