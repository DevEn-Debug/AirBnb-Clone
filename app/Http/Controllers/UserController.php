<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Flat;
use App\Sponsor;
use App\Service;
use App\Photo;
use App\User;
use App\Visit;
use App\Message;
use Carbon\Carbon;



class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
// partendo da Home->Login/id(user)->BecomeHost->Form(Host)->

// Mostra il form per il create User 2 Host
    public function becomeHost(){
        $flats = Flat::all();
        $services = Service::all();
        return view('become_host', compact('flats', 'services'));
    }

    // mostra il form per l'update
    public function update($id){
        $flats = Flat::all();
        $flat = Flat::findOrFail($id);
        $services = Service::all();
        return view('edit_flat', compact('flat', 'services','flats'));
    }

    public function editFlat(Request $request, $id){   //$id => $id(flat)
        $services = Service::all();
        $data = $request -> all();
        $data = $request -> validate([
            'title' => ['required', 'string', 'min:5', 'max:80'],
            'description' => ['required', 'string', 'min:5', 'max:1000'],
            'type' => 'required',
            'photo_url' => 'required|image|mimes:JPG,jpeg,png,jpg,webp', // l'upload deve essere un'immagine valida con queste estensioni
            'price_at_night' => 'required|integer|gte:1',
            'mq' => 'required|integer|gte:5',
            'number_of_bed' => 'required',
            'number_of_bathroom' => 'required',
            'number_of_room' => 'required',
            'WiFi' => 'integer',
            'Parking_Spot' => 'integer',
            'Pool' => 'integer',
            'Reception' => 'integer',
            'Sauna' => 'integer',
            'Sea_View' => 'integer',
            'latitude' => 'string',
            'longitude' => 'string',
            'address' => ['required', 'regex:/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9 \-_\,ìùàòèé]+)$/'] // regex il controllo dell'indirizzo corretto (must contain int|special char)
            ]);

        // prendo tutta l'array dalla request
        $imagePath = $request-> photo_url;
        // prendo solo in nome originale
        $imageName = $imagePath->getClientOriginalName();
        // creo una variabile con dentro le info per per il savataggio e faccio il prepend della data attuale in secondi per evitare conflitti nel nome
        $filePath = $request-> photo_url ->storeAs('images', time().$imageName, 'public');
        // aggiungo la stringa del percorso /storage/ da aggiungere al DB
        $data['photo_url'] = '/storage/'.$filePath;

        $userid = Auth::user()-> id;
        // prendo da data l'user_id della tabella e gli assegno l'id dell'Utente attuale
        $data['user_id'] = $userid;


        $flat = Flat::where('id', $id)->update($data);

    return redirect() -> route('index') -> with('status', 'Appartamento Modificato!!!');
    }

    // nel form al momento de click su submit per far diventare un User->Host
    public function storehost(Request $request, $id ){   //$id => $id(user)

        $services = Service::all();
        $data = $request -> all();

        $data = $request -> validate([
            'title' => ['required', 'string', 'min:5', 'max:80'],
            'description' => ['required', 'string', 'min:5', 'max:1000'],
            'type' => 'required',
            'photo_url' => 'required|image|mimes:JPG,jpeg,png,jpg,webp',
            'price_at_night' => 'required|integer|gte:1',
            'mq' => 'required|integer|gte:5',
            'number_of_bed' => 'required',
            'number_of_bathroom' => 'required',
            'number_of_room' => 'required',
            'WiFi' => 'integer',
            'Parking_Spot' => 'integer',
            'Pool' => 'integer',
            'Reception' => 'integer',
            'Sauna' => 'integer',
            'Sea_View' => 'integer',
            'latitude' => 'string',
            'longitude' => 'string',
            'address' => ['required', 'regex:/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9 \-_\,ìùàòèé]+)$/']
            ]);

        // prendo tutta l'array dalla request
        $imagePath = $request-> photo_url;
        // prendo solo in nome originale
        $imageName = $imagePath->getClientOriginalName();
        // creo una variabile con dentro le info per per il savataggio e faccio il prepend della data attuale in secondi per evitare conflitti nel nome
        $filePath = $request-> photo_url ->storeAs('images', time().$imageName, 'public');
        // aggiungo la stringa del percorso /storage/ da aggiungere al DB
        $data['photo_url'] = '/storage/'.$filePath;

        // prendo da data l'user_id della tabella e gli assegno l'id dell'Utente attuale
        $data['user_id'] = $id;
        $flat = Flat::create($data);

          //  parte dedicata alle checkbox
        if (isset($data['WiFi'])) { // se WIFI è stato impostato o checkato
          $wifi_id = $data['WiFi'];
          $service = Service::findOrFail($wifi_id);
          $service -> flats() -> attach($flat); // scrivo all'interno della tabella ponte collegando il servizio con il flat tramite l'uso della funzione flats() del model
        }
        if (isset($data['Parking_Spot'])) {
          $park_id = $data['Parking_Spot'];
          $service = Service::findOrFail($park_id);
          $service -> flats() -> attach($flat);
        }
        if (isset($data['Pool'])) {
          $pool_id = $data['Pool'];
          $service = Service::findOrFail($pool_id);
          $service -> flats() -> attach($flat);
        }
        if (isset($data['Reception'])) {
          $rece_id = $data['Reception'];
          $service = Service::findOrFail($rece_id);
          $service -> flats() -> attach($flat);
        }
        if (isset($data['Sauna'])) {
          $sauna_id = $data['Sauna'];
          $service = Service::findOrFail($sauna_id);
          $service -> flats() -> attach($flat);
        }
        if (isset($data['Sea_View'])) {
          $sea_id = $data['Sea_View'];
          $service = Service::findOrFail($sea_id);
          $service -> flats() -> attach($flat);
        }

        return redirect() -> route('index') -> with('status', 'Nuovo Appartamento Creato!!!');
    }

    // salvataggio dei messaggio all'interno del DB
    public function storeMessagesUser(Request $request, $id){
        $usermail = Auth::user()-> email;
        $data = $data = $request -> all();
        $data = $request -> validate([
            'name' => ['required', 'min:2', 'max:40'],
            'subject' => ['required', 'min:2', 'max:40'],
            'message' => ['required', 'min:2', 'max:255']
            ]);
        $data['flat_id'] = $id;
        $data['email'] = $usermail;
        $message = Message::create($data);

        return redirect() -> route('show',$id)-> with('status', 'Messaggio Inviato');
    }

    // mostra il profilo dell'user attuale
    public function showProfile(){
        $photos = Photo::all();
        $flats = Flat::all();
        $sponsors = Sponsor::all();
        $date = Carbon::now();

        return view('profile', compact('flats','sponsors', 'date', 'photos'));
    }

    // mostra il form dedicato alla sponsorizzazione
    public function sponsorForm($id){ // id del flat
        $flats = Flat::all();
        $flat = Flat::findOrFail($id);
        $sponsors = Sponsor::all();
        return view('sponsor_form', compact('sponsors', 'flat','flats'));
    }

    public function sponsorPayment(Request $request, $id){ //id del Flat
        $data = $request -> all();
        $flat = Flat::findOrFail($id);
        $data = $request -> validate([
            'sponsor' => ['required']
            ]);
        $sponsor_array = explode('/', $data['sponsor']); //esplodo l'array dividendola tramite la "/" prendendo id dello sponsor e la durata
        $sponsorId = $sponsor_array[0]; // id dello sponsor a indice 0
        $sponsorDur = $sponsor_array[1]; // durata dello spons
        $sponsor = Sponsor::findOrFail($sponsorId);
        $flat = Flat::findOrFail($id);


        $date = Carbon::now(); // prende l'ora attuale
        $carbon_date = Carbon::parse($date);
        $carbon_date->addHours($sponsorDur); // somma l'orario prendendola dall'array $sponsorDur

        $var1= Carbon::parse($carbon_date);

        // prende la riga del DB di "Sponsor" e la associa alla riga del DB di Flat
        $sponsor-> flats() -> attach($flat, ['date_end'=> $carbon_date]);
        return redirect() -> route('profile') -> with('status', 'Pagamento approvato!!!');
    }

    //uguale allo sponsorForm ma è cliccabile solo quando lo sponsor è scaduto(per poter ri-sponsorizzare)
    public function sponsorFormUpdate($id){
        $flats = Flat::all();
        $flat = Flat::findOrFail($id);
        $sponsors = Sponsor::all();
        return view('sponsor_form_update', compact('sponsors', 'flat','flats'));
    }

    public function sponsorPaymentUpdate(Request $request, $id){ //id del Flat
        $data = $request -> all();
        $data = $request -> validate([
            'sponsor' => ['required']
            ]);
        $sponsor_array = explode('/', $data['sponsor']);
        $sponsorId = $sponsor_array[0];
        $sponsorDur = $sponsor_array[1];
        $sponsor = Sponsor::findOrFail($sponsorId);
        $flat = Flat::findOrFail($id);


        $date = Carbon::now();
        $carbon_date = Carbon::parse($date);
        $carbon_date->addHours($sponsorDur);

        $var1= Carbon::parse($carbon_date);

        $flat_sponsorID = $flat-> sponsors-> first()-> pivot-> id;  // prende l'id dalla tabella ponte 
        $spoID = $flat-> sponsors-> first()-> pivot-> sponsor_id; // prende lo sponsor_id dalla tabella ponte

        // prende la riga del DB di "Sponsor" e la associa alla riga del DB di Flat ed esegue l'update senza creare nuovi elementi
        $flat-> sponsors()->wherePivot('id',$flat_sponsorID)->updateExistingPivot($spoID, ['sponsor_id' => $sponsorId,'date_end' => $carbon_date]);
        return redirect() -> route('profile') -> with('status', 'Pagamento approvato!!!');
    }

    // per disabilitare l'appartamento 
    public function disable($id){
        $flat = Flat::findOrFail($id);
        $flat -> update(array('disactive' => 1));
        return redirect() -> route('profile');
    }
    // per ri-abilitarlo
    public function enable($id){
        $flat = Flat::findOrFail($id);
        $flat -> update(array('disactive' => 0));
        return redirect() -> route('profile');
    }
    // esegue una cancellazione logico senza cancellare nulla dal DB (viene solo nascosta a tutti)
    public function delete($id){
        $flat = Flat::findOrFail($id);
        $flat -> update(array('deleted' => 1));
        return redirect() -> route('profile');
    }
    public function showMessage($id){
        $photos = Photo::all();
        $flat = Flat::findOrFail($id);
        $flats = Flat::all();
        $messages = Message::all();
        return view('message', compact('flat', 'messages','flats', 'photos'));
    }

    // parte dedicata alle statistiche dell'appartamento
    public function showStats($id){

      $flats = Flat::all();
      $flat = Flat::findOrFail($id);
      $visits = Visit::all();
      $messages = Message::all();
      $visitTOT = 0;
      $visitTOTtoday = 0;
      $messageTOT = 0;
      $massageTOTtoday = 0;
      // array per salvare le chiavi=>valore dove (chiave = data espressa in ore) e (valore = dato da salvare all'interno del chart)
      $dataVisits = [
        0=>0,
        1=>0,
        2=>0,
        3=>0,
        4=>0,
        5=>0,
        6=>0,
        7=>0,
        8=>0,
        9=>0,
        10=>0,
        11=>0,
        12=>0,
        13=>0,
        14=>0,
        15=>0,
        16=>0,
        17=>0,
        18=>0,
        19=>0,
        20=>0,
        21=>0,
        22=>0,
        23=>0
      ];
      $dataMessages= [
        0=>0,
        1=>0,
        2=>0,
        3=>0,
        4=>0,
        5=>0,
        6=>0,
        7=>0,
        8=>0,
        9=>0,
        10=>0,
        11=>0,
        12=>0,
        13=>0,
        14=>0,
        15=>0,
        16=>0,
        17=>0,
        18=>0,
        19=>0,
        20=>0,
        21=>0,
        22=>0,
        23=>0
      ];

      foreach ($visits as $visit) {
        $from_date2hour = Carbon::parse($visit['date'])-> format('Ymd'); // prendo dala singolo $visit il 'date' e la converto in formato Ymd
        $data_hour_now = Carbon::now()-> format('Ymd');
        $counter = $visit['counter'];

        if ($visit['flat_id'] == $id) { // se il flat_id di visit è uguale all'id passato come argomento (l'id del flat)
          $visitTOT += $counter; // aggiungi alla variabile visitTOT il valore del 'counter'
          if ( $data_hour_now == $from_date2hour) { // se la data espressa in giorni è ugale a quella attuale
            $visitTOTtoday += $counter;
            $hour = intval(Carbon::parse($visit['date'])-> format('H')); // conversione ad intero del Carbon in formato in ore
            $dataVisits[$hour] = $counter; // salva nell'array dataVisits nell'indece di hours il valore delle visualizzazioni
          }
        }
      }

      foreach ($messages as $message) {
        $from_day = Carbon::parse($message['created_at'])-> format('Ymd');
        $data_day_now = Carbon::now()-> format('Ymd');
        if ($message['flat_id'] == $id) {
            $messageTOT += 1;
            if ( $data_day_now == $from_day) {
              $massageTOTtoday += 1;
              $from_date2hour = Carbon::parse($message['created_at'])-> format('H');
              $data_hour_now = Carbon::now()-> format('H');
              if ($from_date2hour == $data_hour_now) {
                $hour = intval(Carbon::parse($message['created_at'])-> format('H'));
                $dataMessages[$hour] +=1;
              }
            }
        }
      }

      $datamessage = implode(' ' , $dataMessages); // convertiamo da array a stringa, aggiungendo uno spazio alla fine di ogni valore
      $datavisit = implode(' ' , $dataVisits);
      return view('stats', compact('visitTOT','visitTOTtoday', 'messageTOT','massageTOTtoday','datavisit','datamessage','flats'));
    }

    
    public function photo($id){
      $flats = Flat::all();
        $photos = Photo::all();
        $flat = Flat::findOrFail($id);
        return view('photo', compact('photos','flat','flats'));
    }
    
    public function storePhoto(Request $request , $id){
      $data = $request -> all();
      $data = $request -> validate(['photo_url' => 'required|image|mimes:JPG,jpeg,png,jpg,webp']);
      $data['flat_id'] = $id;
      // prendo tutta l'array dalla request
      $imagePath = $request-> photo_url;
      // prendo solo in nome originale
      $imageName = $imagePath->getClientOriginalName();
      // creo una variabile con dentro le info per per il savataggio e faccio il prepend della data attuale in secondi per evitare conflitti nel nome
      $filePath = $request-> photo_url ->storeAs('images', time().$imageName, 'public');
      // aggiungo la stringa del percorso /storage/ da aggiungere al DB
      $data['photo_url'] = '/storage/'.$filePath;
      $photo = Photo::create($data);
        return redirect() -> route('profile');
    }

}


