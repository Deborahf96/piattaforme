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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/modifica_password', 'ResettaPasswordController@resetta_password_view');
Route::post('/modifica-password', 'ResettaPasswordController@cambia_password');

Route::resource('/clienti', 'ClienteDipendenteController');
Route::group(['prefix' => 'clienti'], function () {
    Route::post('/table-clienti', 'ClienteDipendenteController@tableClienti');
    Route::get('/{c}/prenotazioni', 'ClienteDipendenteController@prenotazioni');
});

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

Route::resource('/ditte_esterne', 'DittaEsternaController');
Route::group(['prefix' => 'ditte_esterne'], function () {
    Route::post('/aggiungi-ditta', 'DittaEsternaController@aggiungiDitta');
    Route::post('/modifica-ditta', 'DittaEsternaController@modificaDitta');
    Route::post('/elimina', 'DittaEsternaController@elimina');
    Route::post('/table-ditte', 'DittaEsternaController@tableDitte');
});

Route::resource('/attivita', 'AttivitaController');
Route::group(['prefix' => 'attivita'], function () {
    Route::post('/aggiungi-attivita', 'AttivitaController@aggiungiAttivita');
    Route::post('/modifica-attivita', 'AttivitaController@modificaAttivita');
    Route::post('/elimina', 'AttivitaController@elimina');
    Route::post('/table-attivita', 'AttivitaController@tableAttivita');
});

Route::resource('/dipendenti', 'DipendenteController');
Route::group(['prefix' => 'dipendenti'], function () {
    Route::post('/aggiungi-dipendente', 'DipendenteController@aggiungiDipendente');
    Route::post('/modifica-dipendente', 'DipendenteController@modificaDipendente');
    Route::post('/elimina', 'DipendenteController@elimina');
    Route::post('/table-dipendenti', 'DipendenteController@tableDipendenti');
});

Route::resource('/moduli_assistenza', 'ModuloAssistenzaController');


Route::get('/prenotazioni/{p}/riepilogo', 'PrenotazioneController@riepilogo');
Route::get('/prenotazioni/prenota', 'PrenotazioneController@prenota');
Route::post('/prenotazioni/{p}/check', 'PrenotazioneController@conferma_annulla_check');
Route::resource('/prenotazioni', 'PrenotazioneController');


Route::get('/prenotazioni_cliente/{p}/riepilogo', 'PrenotazioneClienteController@riepilogo');
Route::get('/prenotazioni_cliente/prenota', 'PrenotazioneClienteController@prenota');
Route::resource('/prenotazioni_cliente', 'PrenotazioneClienteController');

Route::get('/accesso_negato_clienti', 'AccessoNegatoController@accesso_negato_clienti');
Route::get('/accesso_negato_dipendenti', 'AccessoNegatoController@accesso_negato_dipendenti');
Route::get('/', 'AccessoNegatoController@dashboard');
Route::get('/info', 'AccessoNegatoController@info');


