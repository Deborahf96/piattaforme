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
Route::resource('/ditte_esterne', 'DittaEsternaController');
Route::resource('/camere', 'CameraController');
Route::resource('/clienti_latoDipendente', 'ClienteDipendenteController');
Route::get('/clienti_latoDipendente/{c}/prenotazioni', 'ClienteDipendenteController@prenotazioni');

Route::resource('/attivita', 'AttivitaController');
Route::resource('/dipendenti', 'DipendenteController');
Route::resource('/moduli_assistenza', 'ModuloAssistenzaController');


Route::get('/prenotazioni/{p}/riepilogo', 'PrenotazioneController@riepilogo');
Route::get('/prenotazioni/prenota', 'PrenotazioneController@prenota');
Route::post('/prenotazioni/{p}/check', 'PrenotazioneController@conferma_annulla_check');
Route::resource('/prenotazioni', 'PrenotazioneController');

Route::get('/prenotazioni_cliente/prenota', 'PrenotazioneClienteController@prenota');
Route::resource('/prenotazioni_cliente', 'PrenotazioneClienteController');

// Cliente
Route::get('/clienti_latoCliente', 'ClienteClienteController@show');
Route::get('/clienti_latoCliente/edit', 'ClienteClienteController@edit');
Route::match(['put','patch'], '/clienti_latoCliente', 'ClienteClienteController@update');
Route::delete('/clienti_latoCliente', 'ClienteClienteController@destroy');

Route::get('/accesso_negato_clienti', 'AccessoNegatoController@accesso_negato_clienti');
Route::get('/accesso_negato_dipendenti', 'AccessoNegatoController@accesso_negato_dipendenti');
Route::get('/', 'AccessoNegatoController@dashboard');
Route::get('/info', 'AccessoNegatoController@info');

Route::get('/modifica_password', 'ResettaPasswordController@resetta_password_view');
Route::post('/modifica_password/{user_id}', 'ResettaPasswordController@cambia_password');


