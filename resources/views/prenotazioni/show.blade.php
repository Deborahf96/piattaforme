@extends('layouts.app')

<title> Thousand Sunny B&B | Prenotazioni </title>

@section('thousand_sunny_content')
    <a href="/prenotazioni" class="btn btn-outline-secondary">Torna a prenotazioni</a>
    <hr>
    <div class="col-md-12 d-flex align-items-stretch">
        <div class="card card-primary card-outline" style="width: 100%">
            <div class="card-header">
                <h5 class="card-title m-0"><b>Prenotazioni</b></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2"><b>Camera</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->camera->numero }}</div>
                    <div class="col-md-2"><b>Numero di persone</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->num_persone }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Data checkin</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ \Carbon\Carbon::parse($prenotazione->_checkout)->format('d/m/Y') }}
                    </div>
                    <div class="col-md-2"><b>Cliente</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->cliente }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Data checkout</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ \Carbon\Carbon::parse($prenotazione->data_checkout)->format('d/m/Y') }}
                    </div>
                    <div class="col-md-2"><b>Metodo di pagamento</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->metodo_pagamento }}</div>
                </div>
            </div>
        </div>
    </div>

    <a href="/prenotazioni/{{ $prenotazione->id }}/edit" class="btn btn-primary">Modifica</a>
    {!! Form::open(['action' => ['PrenotazioneController@destroy', $prenotazione->id], 'method' => 'POST', 'class' =>
    'float-right']) !!}
    {{ Form::hidden('_method', 'DELETE') }}
    {{ Form::submit('Elimina', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Confermi di voler eliminare questa prenotazione?')"]) }}
    {!! Form::close() !!}
    <hr>

@endsection
