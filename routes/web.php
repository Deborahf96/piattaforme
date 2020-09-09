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
Route::resource('/attivita', 'AttivitaController');
Route::resource('/dipendenti', 'DipendenteController');
<<<<<<< HEAD
Route::resource('/prenotazioni', 'PrenotazioneController');
Route::resource('/moduli_assistenza', 'ModuloAssistenzaController');
=======
Route::resource('/modulo_assistenza', 'ModuloAssistenzaController');
>>>>>>> 665f5797349fccfdff5086df8d2c4e83348969a3

Route::get('/prenotazioni/prenota', 'PrenotazioneController@prenota');
Route::resource('/prenotazioni', 'PrenotazioneController');

Route::get('/prenotazioni_cliente/storico', 'PrenotazioneClienteController@storico');
Route::resource('/prenotazioni_cliente', 'PrenotazioneClienteController');

// Cliente
Route::get('/clienti_latoCliente', 'ClienteClienteController@show');
Route::get('/clienti_latoCliente/edit', 'ClienteClienteController@edit');
Route::match(['put','patch'], '/clienti_latoCliente', 'ClienteClienteController@update');
Route::delete('/clienti_latoCliente', 'ClienteClienteController@destroy');

