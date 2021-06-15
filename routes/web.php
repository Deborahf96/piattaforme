<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');
Route::get('/about_us', 'HomeController@aboutUs')->name('about_us');

Route::get('/modifica_password', 'ResettaPasswordController@resetta_password_view');
Route::post('/modifica-password', 'ResettaPasswordController@cambia_password');

Route::group(['prefix' => 'clienti'], function () {
    Route::post('/table-clienti', 'ClienteDipendenteController@tableClienti');
    Route::post('/table-prenotazioni', 'ClienteDipendenteController@tablePrenotazioniCliente');
    Route::get('/{c}/prenotazioni', 'ClienteDipendenteController@prenotazioni');
});
Route::resource('/clienti', 'ClienteDipendenteController');

Route::group(['prefix' => 'cliente'], function () {
    Route::get('/', 'ClienteClienteController@show');
    Route::get('/edit', 'ClienteClienteController@edit');
    Route::post('/modifica', 'ClienteClienteController@modifica');
    Route::post('/elimina', 'ClienteClienteController@elimina');
});
Route::resource('/camere', 'CameraController');

Route::group(['prefix' => 'camere'], function () {
    Route::post('/aggiungi-camera', 'CameraController@aggiungiCamera');
    Route::post('/modifica-camera', 'CameraController@modificaCamera');
    Route::post('/elimina', 'CameraController@elimina');
    Route::post('/carica-immagine', 'CameraController@caricaImmagine');
    Route::post('/table-camere', 'CameraController@tableCamere');
});

Route::group(['prefix' => 'ditte_esterne'], function () {
    Route::post('/aggiungi-ditta', 'DittaEsternaController@aggiungiDitta');
    Route::post('/modifica-ditta', 'DittaEsternaController@modificaDitta');
    Route::post('/elimina', 'DittaEsternaController@elimina');
    Route::post('/table-ditte', 'DittaEsternaController@tableDitte');
});
Route::resource('/ditte_esterne', 'DittaEsternaController');

Route::group(['prefix' => 'attivita'], function () {
    Route::post('/aggiungi-attivita', 'AttivitaController@aggiungiAttivita');
    Route::post('/modifica-attivita', 'AttivitaController@modificaAttivita');
    Route::post('/elimina', 'AttivitaController@elimina');
    Route::post('/table-attivita', 'AttivitaController@tableAttivita');
});
Route::resource('/attivita', 'AttivitaController');

Route::group(['prefix' => 'dipendenti'], function () {
    Route::post('/aggiungi-dipendente', 'DipendenteController@aggiungiDipendente');
    Route::post('/modifica-dipendente', 'DipendenteController@modificaDipendente');
    Route::post('/elimina', 'DipendenteController@elimina');
    Route::post('/table-dipendenti', 'DipendenteController@tableDipendenti');
});
Route::resource('/dipendenti', 'DipendenteController');

Route::group(['prefix' => 'moduli_assistenza'], function () {
    Route::post('/invia', 'ModuloAssistenzaController@invia');
    Route::post('/table', 'ModuloAssistenzaController@table');
});
Route::resource('/moduli_assistenza', 'ModuloAssistenzaController');

Route::group(['prefix' => 'prenotazioni'], function () {
    Route::get('/riepilogo/{p}', 'PrenotazioneController@riepilogo');
    Route::get('/prenota', 'PrenotazioneController@prenota');
    Route::post('/prenota-camera', 'PrenotazioneController@prenotaCamera');
    Route::post('/pagamento', 'PrenotazioneController@pagamento');
    Route::post('/elimina', 'PrenotazioneController@elimina');
    Route::post('/table-prenotazioni', 'PrenotazioneController@tablePrenotazioni');
    Route::post('/check', 'PrenotazioneController@conferma_annulla_check');
});
Route::resource('/prenotazioni', 'PrenotazioneController')->middleware('dipendenti');
Route::post('/prenotazioni_cliente/table-prenotazioni', 'PrenotazioneClienteController@tablePrenotazioni');
Route::resource('/prenotazioni_cliente', 'PrenotazioneClienteController');

Route::get('/accesso_negato_clienti', 'AccessoNegatoController@accesso_negato_clienti');
Route::get('/accesso_negato_dipendenti', 'AccessoNegatoController@accesso_negato_dipendenti');
Route::get('/', 'AccessoNegatoController@dashboard');
Route::get('/info', 'AccessoNegatoController@info');

Route::post('/prenotazioni/stripe-checkout', 'PrenotazioneController@stripeCheckout')->name('stripe.checkout');
Route::get('/pagamento', 'PrenotazioneController@pagamento');


