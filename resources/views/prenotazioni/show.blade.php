@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/prenotazioni" class="btn btn-outline-secondary">Torna a prenotazioni</a>
    <hr>
    <div class="col-md-12 d-flex align-items-stretch">
        <div class="card card-primary card-outline" style="width: 100%">
            <div class="card-header">
                <h5 class="card-title m-0"><b>Prenotazione</b></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2"><b>Cliente</b></div>
                    <div class="col-md-3 col-md-offset-1">
                        {{ isset($prenotazione->cliente) ? $prenotazione->cliente : $cliente_name }}
                    </div>
                    <div class="col-md-2"><b>Camera</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->camera->numero }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Data check-in</b></div>
                    <div class="col-md-3 col-md-offset-1">
                        {{ \Carbon\Carbon::parse($prenotazione->data_checkin)->format('d/m/Y') }}
                    </div>
                    <div class="col-md-2"><b>Data check-out</b></div>
                    <div class="col-md-3 col-md-offset-1">
                        {{ \Carbon\Carbon::parse($prenotazione->data_checkout)->format('d/m/Y') }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Numero di persone</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->num_persone }}</div>
                    <div class="col-md-2"><b>Metodo di pagamento</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->metodo_pagamento }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Importo</b></div>
                    <div class="col-md-3 col-md-offset-1">
                        {{ isset($prenotazione->importo) ? $prenotazione->importo : '-' }}
                    </div>
                    <div class="col-md-2"><b>Conferma avvenuto pernottamento</b></div>
                    <div class="col-md-3 col-md-offset-1">
                        {{ isset($prenotazione->check_pernottamento) ? $prenotazione->check_pernottamento : '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::open(['action' => ['PrenotazioneController@destroy', $prenotazione->id], 'method' => 'POST', 'class' =>
    'float-right']) !!}
    {{ Form::hidden('_method', 'DELETE') }}
    {{ Form::submit('Annulla', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Confermi di voler annullare questa prenotazione?')"]) }}
    {!! Form::close() !!}
    <hr>

@endsection
