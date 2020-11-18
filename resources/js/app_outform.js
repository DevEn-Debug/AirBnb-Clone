$(document).ready(init)

function autocompleteform(){
  // PARTE AUTOCOMPLETE
  var long;
  var lat;
  var city;
  var placesAutocomplete = places({
      appId: 'pl8W088Q8NFB',
      apiKey: '5f0867802489c340cd8ae9e3a2f0856b',
      container: document.querySelector('#addresshost')
    });

    placesAutocomplete.on('change', function(e) {
      //   $address.textContent = e.suggestion.value


        long = e.suggestion.latlng.lng
        lat = e.suggestion.latlng.lat
        city = e.suggestion.name


        sessionStorage.setItem('long', e.suggestion.latlng.lng)
        sessionStorage.setItem('lat', e.suggestion.latlng.lat);
        sessionStorage.setItem('city', e.suggestion.name);

        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = long;

      });

}


function init (){
 autocompleteform();

}
