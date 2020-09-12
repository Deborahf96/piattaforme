@extends('layouts.app')

@section('thousand_sunny_content')
    <div class="d-flex justify-content-between">
        <a href="/prenotazioni" class="btn btn-outline-secondary">Torna a prenotazioni</a>
        <div>
            {!! Form::open(['action' => ['PrenotazioneController@conferma_annulla_check', $prenotazione->id], 'method' =>
            'POST', 'enctype' => 'multipart/form-data']) !!}
            {{ Form::submit($prenotazione->check_pernottamento == 'Confermato' ? 'Annulla pernottamento' : 'Conferma pernottamento', ['class' => 'btn btn-primary float-right', 'style' => 'margin-right: 10px']) }}
            {!! Form::close() !!}
        </div>
    </div>
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
                    <div class="col-md-2"><b>Posti letto</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->num_persone }}</div>
                    <div class="col-md-2"><b>Metodo di pagamento</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->metodo_pagamento }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Importo</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->importo }} €</div>
                    <div class="col-md-2"><b>Conferma avvenuto pernottamento</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->check_pernottamento }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Attività selezionate</b></div>
                    <div class="col-md-10 col-md-offset-1">
                        <ul>
                            @foreach ($prenotazione->attivita as $singola_attivita)
                                <li>
                                    <a href="/attivita/{{$singola_attivita->id}}" class="btn btn-link">
                                    {{ \Carbon\Carbon::parse($singola_attivita->data)->format("d/m/Y") }}  -  {{ \Carbon\Carbon::parse($singola_attivita->ora)->format("H:i") }}  |  {{ $singola_attivita->destinazione }}  |  {{ $singola_attivita->tipologia }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($prenotazione->cliente == null)
        <a href="/clienti_latoDipendente/{{ $prenotazione->cliente_user_id }}"  class="btn btn-info" style="margin-right: 10px">Visualizza profilo cliente</a>
    @endif
    <button type="button" class="btn btn-info disabled" style="margin-right: 10px">Visualizza fattura</button>

{!! Form::open(['action' => ['PrenotazioneController@destroy', $prenotazione->id], 'method' => 'POST', 'class' =>
    'float-right']) !!}
    {{ Form::hidden('_method', 'DELETE') }}
    {{ Form::submit('Annulla', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Confermi di voler annullare questa prenotazione?')"]) }}
    {!! Form::close() !!}
    <br>
    <br>
    <hr>
@endsection
