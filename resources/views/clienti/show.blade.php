@extends('layouts.app')

<title> Thousand Sunny B&B | Clienti </title>

@section('thousand_sunny_content')
    @php $url_previous = URL::previous() @endphp
    @if ($url_previous === 'http://localhost:8080/clienti')
        <a href="/clienti" class="btn btn-outline-secondary">Torna a clienti</a>
    @else
        <a href="/" class="btn btn-outline-secondary">Indietro</a>
    @endif
    <hr>
    <div class="col-md-12 d-flex align-items-stretch">
        <div class="card card-primary card-outline" style="width: 100%">
            <div class="card-header">
                <h5 class="card-title m-0"><b>Cliente</b></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2"><b>Nome completo</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $cliente->utente->name }}</div>
                    <div class="col-md-2"><b>Data di nascita</b></div>
                    <div class="col-md-3 col-md-offset-1">
                        {{ isset($cliente->utente->data_nascita) ? $cliente->utente->data_nascita : '-' }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Luogo di nascita</b></div>
                    <div class="col-md-3 col-md-offset-1">
                        {{ isset($cliente->utente->luogo_nascita) ? $cliente->utente->luogo_nascita : '-' }}
                    </div>
                    <div class="col-md-2"><b>Indirizzo</b></div>
                    <div class="col-md-3 col-md-offset-1">
                        {{ isset($cliente->utente->indirizzo) ? $cliente->utente->indirizzo : '-' }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Telefono</b></div>
                    <div class="col-md-3 col-md-offset-1">
                        {{ isset($cliente->utente->telefono) ? $cliente->utente->telefono : '-' }}</div>
                    <div class="col-md-2"><b>Email</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $cliente->utente->email }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Metodo di pagamento</b></div>
                    <div class="col-md-3 col-md-offset-1">
                        {{ isset($cliente->metodo_pagamento) ? $cliente->metodo_pagamento : '-' }}</div>
                </div>
            </div>
        </div>
    </div>
    @if ($url_previous === 'http://localhost:8080/clienti')
    @else
        <a href="/clienti/{{ $cliente->user_id }}/edit" class="btn btn-primary">Modifica</a>
        <a class="btn btn-info">Visualizza prenotazioni</a>
        {!! Form::open(['action' => ['ClienteController@destroy', $cliente->user_id], 'method' => 'POST', 'class' =>
        'float-right']) !!}
        {{ Form::hidden('_method', 'DELETE') }}
        {{ Form::submit('Elimina', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Confermi di voler eliminare questo account? ')"]) }}
        {!! Form::close() !!}
    @endif
@endsection
