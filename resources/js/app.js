
require('./bootstrap');

window.Vue = require('vue');
window.$ = require('jquery');



$(document).ready(init)


function autocompletesearch(){
  // PARTE AUTOCOMPLETE
  var long;
  var lat;
  var city;
  var placesAutocomplete = places({
      appId: 'pl8W088Q8NFB',
      apiKey: '5f0867802489c340cd8ae9e3a2f0856b',
      container: document.querySelector('#address-input')
    });

    placesAutocomplete.on('change', function(e) {
      //   $address.textContent = e.suggestion.value


        long = e.suggestion.latlng.lng
        lat = e.suggestion.latlng.lat
        city = e.suggestion.name


        sessionStorage.setItem('long', e.suggestion.latlng.lng)
        sessionStorage.setItem('lat', e.suggestion.latlng.lat);
        sessionStorage.setItem('city', e.suggestion.name);

        document.cookie = `lat=${lat}`;
        document.cookie = `long=${long}`;
        document.cookie = `city=${city}`;
      });
}

function setDistance(){
  const $valueSpan = $('.valueSpan2');
    const $value = $('#customRange11');
    $valueSpan.html($value.val());
    $value.on('input change', () => {

      $valueSpan.html($value.val());
      var distance = $value.val();
      document.cookie = `distance=${distance}`;
    });
}


function init() {


    document.cookie = `lat=${""}`;
    document.cookie = `long=${""}`;
    document.cookie = `city=${""}`;
    document.cookie = `distance=${""}`;



      autocompletesearch();
      setDistance();

      //Menu Toggle Script
        $("#menu-toggle").click(function(e) {
          e.preventDefault();
          $("#wrapper").toggleClass("toggled");
        });
    }
