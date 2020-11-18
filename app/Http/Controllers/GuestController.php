<?php
namespace App\Http\Controllers;
use App\Flat;
use App\Sponsor;
use App\Service;
use App\Photo;
use App\User;
use App\Visit;
use App\Message;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;



use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index(){
        $flats = Flat::all();
        $date = Carbon::now();
        $sponsors = Sponsor::all();
        $photos = Photo::all();
        return view('index', compact('flats','sponsors','date','photos'));
    }


    public function search(){
      
      $sponsors = Sponsor::all();
      $services = Service::all();
      $photos = Photo::all();
      $flats = Flat::all();
      $latitude = $_COOKIE['lat']; // prendo la latitudine tramite COOKIE
      $longitude = $_COOKIE['long']; // prendo la longitude tramite COOKIE
      $city = '';
      $date = Carbon::now();
      if (empty($_COOKIE['distance'])) { // se il parametro COOKIE è vuoto
        $distance = 20; // distanza di default impostata a 20km
      }
      else {
        $distance = $_COOKIE['distance']; // altrimenti prendi la dist scelta dai COOKIE
      }
      if (!(empty($latitude))) { // in caso viene impostata un parametro di ricerca
        $city = $_COOKIE['city'];
        foreach ($flats as $flat) {
          $id = $flat-> id;
        $flatsNoSponsor = Flat::with('sponsors')->whereDoesntHave('sponsors', function($query) use ($id) {$query->where('flat_id', '!=', $id);})->get(); //viene salvato in un'array il raggruppamento di tutti i flat che NON sono sponsorizzati
        $flatsSponsor = Flat::with('sponsors')->whereHas('sponsors', function($query) use ($id) {$query->where('flat_id', '!=', $id);})->get(); // viene salvato in un'array il raggruppamento di tutti i flat che sono sponsorizzati
        }
      }
      else { //in caso NON viene impostata un parametro di ricerca
        foreach ($flats as $flat) {
          $id = $flat-> id;
        $flatsNoSponsor = Flat::with('sponsors')->whereDoesntHave('sponsors', function($query) use ($id) {$query->where('flat_id', '!=', $id);})->get(); // prende tutte le info nella tabella sponsors e confronta se il flat_id è diverso dall'id della tabella ponte
        $flatsSponsor = Flat::with('sponsors')->whereHas('sponsors', function($query) use ($id) {$query->where('flat_id', '!=', $id);})->get(); // il contrario
        }
      }

        return view('search', compact('flatsNoSponsor','flatsSponsor','sponsors', 'services','city','latitude','longitude','distance','flats', 'date', 'photos'));
    }

    public function searchsort(request $request){ // funzione richiamata da JS tramite un'AJAX(GET)
      if (empty($_COOKIE['nofroom'])) { // se il numero delle stanze non è stato filtrato
        $nofroom = 0; // valore di default
      }
      else {
        $nofroom = $_COOKIE['nofroom']; // se il valore è stato impostato allora prende il dato dai COOKIE
      }
      if (empty($_COOKIE['nofbed'])) {
        $nofbed = 0;
      }
      else {
        $nofbed = $_COOKIE['nofbed'];
      }
        $data = $request -> all();
        $srvs = $data['service']; // prendo l'unico indice(chiave)  salvato in servizi
        if(isset($srvs)){ // se la variabile è stata settata(filtro)
            $arraySrvs = explode(',', $srvs); 
        } else {
            $arraySrvs = [];
        }
        $flats = Flat::where([['disactive', '=', '0'],['deleted', '=', '0'],['number_of_bed', '>=', $nofbed],['number_of_room', '>=', $nofroom]]) -> get(); // condizioni da metchare,prende solo gli appartamenti che soddisfano queste condizioni
        foreach ($flats as $flat) {
            $services = Flat::findOrFail($flat['id']) -> services() -> get();
            $aptSrvs = [];
            foreach ($services as $service) {
                $aptSrvs[] = $service['id'];
            }
            $containsAllValues = !array_diff($arraySrvs, $aptSrvs); // viene confrontata l'array di arraySrvs con aptSrvs e salva le differenze in questa array

            $flat['services'] = $containsAllValues;
        }
        $response = $flats -> where('services', '=', true); // flats dove i servizi sono impostati a true(1)
        return response() -> json($response);

    }

    public function show($id){
        $flats = Flat::all();
        $photos = Photo::all();
        $flat = Flat::findOrFail($id);
        $visits = Visit::all();
        $services = Service::all();
        $messages = Message::all();
        $date = Carbon::now();

        if (empty(Auth::user()-> id) || (Auth::user()-> id != $flat['user_id']) ){ // se l'utente attuale è un guest o se non è il proprietario dell'app
          if (!(empty($visits->first() ))) { // se esiste contenuto nella prima riga della tabella visits
            $data_hour_now = Carbon::now()-> format('YmdH'); // data nel momento in cui viene visualizzata la show in formato year month day hours
            $conteggio_aumentato=false; // inizializzo una variabile d'appoggio
            foreach ($visits as $visit) { // comincio a ciclare ma non scrivo mai niente
              $from_date2hour = Carbon::parse($visit['date'])-> format('YmdH'); // prendo la data all'interno della tab visit, ra rendo leggiabile a Carbon tramite parse()
              if ($visit['flat_id'] == $flat['id'] && $data_hour_now == $from_date2hour){  // se trovo un match allora modifico la variabile d'appoggio e scrivo sul DB
                $visit2up = $visit['counter'] += 1;
                $visit -> update(array('counter' => $visit2up));
                $conteggio_aumentato=true; // la variabile d'appoggio cambia
                break;
              }
            }
            if($conteggio_aumentato == false){ // se tutto il ciclo è falso e la variabile non è cambiata allora creo un nuova riga
              $data = ['date' => $date,
              'flat_id' => $id,
              'counter' => 1];
              $row_visit = Visit::create($data);
            }
          }
          else { // se nella tabella non esiste nulla allora scrivo una nuova riga
            $data = ['date' => $date,
            'flat_id' => $id,
            'counter' => 1];
            $row_visit = Visit::create($data);
          }
        }
        return view('show', compact('flat','flats','services', 'photos'));
    }

    public function storeMessagesGuest(Request $request, $id){
        $data = $request -> all();
        $data = $request -> validate([
            'name' => ['required', 'min:2', 'max:40'],
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/^(?=.*\.)/'], // regular expression per controllare che contenga almeno un punto || e laravel si occupa che sia presente almeno una @
            'subject' => ['required', 'min:2', 'max:40'],
            'message' => ['required', 'min:2', 'max:255']
            ]);
        $data['flat_id'] = $id;
        $message = Message::create($data);
        return redirect() -> route('index')-> with('status', 'Messaggio Inviato');
    }
}
