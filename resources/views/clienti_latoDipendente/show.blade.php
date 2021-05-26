@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="{{URL::previous()}}" class="btn btn-outline-secondary">Indietro</a>
    <br>
    <br>
    <div class="card card-primary card-outline">
        <div class="card-header d-flex p-0">
            <h5 class="card-title p-3">Cliente</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"><b>Nome completo</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $cliente->utente->name }}</div>
                <div class="col-md-2"><b>Data di nascita</b></div>
                <div class="col-md-3 col-md-offset-1">{{ isset($cliente->utente->data_nascita) ? $cliente->utente->data_nascita : '-' }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Luogo di nascita</b></div>
                <div class="col-md-3 col-md-offset-1">{{ isset($cliente->utente->luogo_nascita) ? $cliente->utente->luogo_nascita : '-' }}</div>
                <div class="col-md-2"><b>Indirizzo</b></div>
                <div class="col-md-3 col-md-offset-1">{{ isset($cliente->utente->indirizzo) ? $cliente->utente->indirizzo : '-' }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Telefono</b></div>
                <div class="col-md-3 col-md-offset-1">{{ isset($cliente->utente->telefono) ? $cliente->utente->telefono : '-' }}</div>
                <div class="col-md-2"><b>Email</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $cliente->utente->email }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Metodo di pagamento</b></div>
                <div class="col-md-3 col-md-offset-1">{{ isset($cliente->metodo_pagamento) ? $cliente->metodo_pagamento : '-' }}</div>
            </div>
        </div>
    </div>
    <a href="/clienti_latoDipendente/{{ $cliente->user_id }}/prenotazioni" class="btn btn-info" style="margin-right: 10px">Visualizza prenotazioni</a>
</div>
@stop
