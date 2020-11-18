@extends('layouts.app')

@section('content')
<div style="width: 100%;height: 15px;background: rgb(131,58,180);background: linear-gradient(90deg, rgba(131,58,180,0.6671043417366946) 0%, rgba(253,29,29,0.7287289915966386) 50%, rgba(252,176,69,0.6502976190476191) 100%);"></div>
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

<div class="container">
    <div class="row justify-content-center" style="padding : 60px 0;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"
                  style="text-align:center; color:#ffff; font-weight:bold background: rgb(131,58,180);background: linear-gradient(90deg, rgba(131,58,180,0.6671043417366946) 0%, rgba(253,29,29,0.7287289915966386) 50%, rgba(252,176,69,0.6502976190476191) 100%);">
                    Sponsorizza il tuo annuncio</div>

                <div class="card-body">
                    <form action="{{route('sponsorPaymentUpdate', $flat-> id)}} " method="post">
                        @csrf
                        @method('POST')

                        @foreach ($sponsors as $sponsor)
                        <div class="form-check">
                            <input type="radio" name="sponsor" id="{{$sponsor-> id}}" class="form-check-input @error('sponsor') is-invalid @enderror" value="{{$sponsor-> id}}/{{$sponsor-> duration}}" >
                            <label class="form-check-label" for="{{$sponsor-> id}}">Sponsorizza il tuo annuncio per {{$sponsor-> duration}}H al costo di {{$sponsor-> cost}}</label>
                        </div>
                        @endforeach
                        @error('sponsor')
                        <span class="invalid-feedback" style="display: block" role="alert">
                            <strong>{{$message}} </strong>
                        </span>
                        @enderror
                        <div id="dropin-container" style="margin-top:20px;"></div>
                        <a class="btn btn-primary" id="submit-button">Request payment method</a>
                        <button id="compra" type="submit" class="btn btn-success none">Paga</button>
                    </form>


                    <script type="text/javascript">
                        braintree.dropin.create({
                            authorization: "{{ Braintree\ClientToken::generate() }}",
                            container: '#dropin-container'
                        }, function(createErr, instance) {
                            var button = document.querySelector('#submit-button');
                            button.addEventListener('click', function() {
                                instance.requestPaymentMethod(function(err, payload) {
                                    if (typeof(payload) != "undefined") {
                                        var element = document.getElementById("compra");
                                        element.classList.add("display");
                                        var element2 = document.getElementById("submit-button");
                                        element2.classList.add("none");
                                        console.log(payload);
                                    }



                                });
                            });
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
