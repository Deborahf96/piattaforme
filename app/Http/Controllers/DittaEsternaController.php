<?php

namespace App\Http\Controllers;

use App\DittaEsterna;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class DittaEsternaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*visualizzare le ditte. è un metodo che ci porta alla pagine per visualizzare tutte le ditte.
        Partiamo da una query sul database
        */
        $ditte_esterne = DittaEsterna::all();     //equivale alla SELECT ALL sul database (per prendere tutte le ditte). Ha un return di tipo lista
        $data = [
            'ditte_esterne' => $ditte_esterne           //=> quando si fa chiave->valore (mappa in java)
        ];
        return view('ditte_esterne.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //mostra la pagina per creare la pagina per aggiungere dati
        return view('ditte_esterne.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //store è l'operazione effettiva di add
        $ditta_esterna = new DittaEsterna;   //non c'è il costruttore in DittaEsterna quindi non c'è bisogno di mettere le parentesi
        $this->valida_richiesta($request, $ditta_esterna);      //request: dati che vengono inseriti nella GUI. Se la validazione non va a buon fine torna nella stessa pagina specificata in redirect ma con un messaggio di errore
        $this->salva_ditta($request, $ditta_esterna);           //fa la add sul database
        return redirect('/ditte_esterne')->with('success', 'Ditta inserita con successo');
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($partita_iva)
    {
        //pagina di dettaglio (quando apriamo ad esempio una singola ditta esterna)
        $ditta_esterna = DittaEsterna::where('partita_iva', $partita_iva)->first();
        $data = [
            'ditta_esterna' => $ditta_esterna
        ];
        return view('ditte_esterne.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($partita_iva)
    {
        //mostra la pagina con i dati già pronti
        $ditta_esterna = DittaEsterna::where('partita_iva', $partita_iva)->first();        //il metodo find funziona solo con l'id di Laravel; cerca nella tabella un elemento con quell'id. Utilizziamo la where
        //where(nome colonna, valore) //first per dire di prendere il primo elemento e non una lista, proprio perché la where si può fare anche su un attributo non chiave. Per avere la lista bisognava usare la get
        $data = [
            'ditta_esterna' => $ditta_esterna
        ];
        return view('ditte_esterne.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $partita_iva)
    {
        //salva i dati della modifica
        $ditta_esterna = DittaEsterna::where('partita_iva', $partita_iva)->first();
        $this->valida_richiesta($request, $ditta_esterna);      //request: dati che vengono inseriti nella GUI. Se la validazione non va a buon fine torna nella stessa pagina specificata in redirect ma con un messaggio di errore
        $this->salva_ditta($request, $ditta_esterna);           //fa la add sul database
        return redirect('/ditte_esterne')->with('success', 'Ditta modificata con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($partita_iva)
    {
        //elimina
        $ditta_esterna = DittaEsterna::where('partita_iva', $partita_iva)->first();
        $ditta_esterna->delete();
        return redirect('/ditte_esterne')->with('success', 'Ditta eliminata con successo');
    }
    

    private function valida_richiesta(Request $request, $ditta_esterna)
    {
        $rules = [                              //unique su un parametro controlla che ci sia un solo valore per quel parametro. Il punto serve per concatenare le stringhe
            'partita_iva' => 'required|max:11|unique:ditta_esterna,partita_iva,'.$ditta_esterna->partita_iva,            //required = obbligatorio, nullable = opzionale (Per altre validazione vedere documentazione The Basics --> Validation)
            'nome' => 'required|max:255',             
            'indirizzo' => 'required|max:255',             
            'telefono' => 'required|numeric',
            'email' => 'required|email',
            'iban' => 'required|max:27|min:27',
            'descrizione' => 'required|max:255',
            'tipo_contratto' => 'required|max:255',
            'paga' => 'required|max:255',
            'data_inizio' => 'required|date',
            'data_fine' => 'required|date',
        ];
        $customMessages = [
            'partita_iva.required' => "E' necessario inserire il parametro 'Partita Iva'",            
            'partita_iva.max' => "Il numero massimo di caratteri consentito per 'Partita Iva' è 11",             
           
            //Inserire anche gli altri attributi

        ];
        $this->validate($request, $rules, $customMessages);     //richiesta che arriva dalla GUI, regole: stringa di massimo numero di caratteri ad esempio, messaggio da mostrare
    }

    private function salva_ditta(Request $request, $ditta_esterna)              //ha bisogno di passargli come parametro il DittaEsterna creato in store
    {
        //il metodo da errore quando salviamo dei dati che sul database non vanno bene (incompatibilità dei tipi)

        $ditta_esterna->partita_iva = $request->input('partita_iva');           //è l'equivalente dei metodi set in Java
        $ditta_esterna->nome = $request->input('nome');
        $ditta_esterna->indirizzo = $request->input('indirizzo');
        $ditta_esterna->telefono = $request->input('telefono');
        $ditta_esterna->email = $request->input('email');
        $ditta_esterna->iban = $request->input('iban');
        $ditta_esterna->descrizione = $request->input('descrizione');
        $ditta_esterna->tipo_contratto = $request->input('tipo_contratto');
        $ditta_esterna->paga = $request->input('paga');
        $ditta_esterna->data_inizio = $request->input('data_inizio');
        $ditta_esterna->data_fine = $request->input('data_fine');
        $ditta_esterna->save();                                                 //salva caricando i dati sul database
    }

}
