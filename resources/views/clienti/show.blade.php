@extends('layouts.app')

@section('thousand_sunny_content')
<a href="/clienti" class="btn btn-outline-secondary">Torna a clienti</a>
<hr>
<div class="col-md-12 d-flex align-items-stretch">
    <div class="card card-primary card-outline" style="width: 100%">
        <div class="card-header">
            <h5 class="card-title m-0"><b>Cliente</b></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"><b>Nome</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $cliente->nome }}</div>
                <div class="col-md-2"><b>Cognome</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $cliente->cognome }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Data nascita</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $cliente->data_nascita }}</div>
                <div class="col-md-2"><b>Luogo nascita</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $cliente->luogo_nascita }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Indirizzo</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $cliente->indirizzo }}</div>
                <div class="col-md-2"><b>Telefono</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $cliente->telefono }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Email</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $cliente->email }}</div>
                <div class="col-md-2"><b>Password</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $cliente->password }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Metodo di pagamento</b></div>
                <div class="col-md-8 col-md-offset-1">{{ $cliente->metodo_pagamento }}</div>
            </div>
        </div>
    </div>
</div>

@endsection