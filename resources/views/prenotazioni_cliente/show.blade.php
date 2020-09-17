@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/prenotazioni_cliente" class="btn btn-outline-secondary">Torna allo storico prenotazioni</a>
    <hr>
    <div class="col-md-12 d-flex align-items-stretch">
        <div class="card card-primary card-outline" style="width: 100%">
            <div class="card-header">
                <h5 class="card-title m-0"><b>Prenotazione</b></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2"><b>Posti letto</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->num_persone }}</div>
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
                    <div class="col-md-2"><b>Metodo di pagamento</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->metodo_pagamento }}</div>
                    <div class="col-md-2"><b>Importo</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->importo }} €</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Attività selezionate</b></div>
                    <div class="col-md-10 col-md-offset-1">
                        <ul>
                            @foreach ($prenotazione->attivita as $singola_attivita)
                                <li>
                                    {{ \Carbon\Carbon::parse($singola_attivita->data)->format("d/m/Y") }}  -  {{ \Carbon\Carbon::parse($singola_attivita->ora)->format("H:i") }}  |  {{ $singola_attivita->destinazione }}  |  {{ $singola_attivita->tipologia }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="/camere/{{ $prenotazione->camera->numero }}"  class="btn btn-info" style="margin-right: 10px">Visualizza caratteristiche camera</a>
    <button type="button" class="btn btn-info disabled" style="margin-right: 10px">Visualizza fattura</button>
    <button type="button" class="btn btn-info disabled" style="margin-right: 10px">Inserisci recensione</button>

    @php $giorni_di_differenza = (\Carbon\Carbon::now()->diffinDays(\Carbon\Carbon::parse($prenotazione->data_checkout), false)) @endphp
    @if($giorni_di_differenza>=14)
    <div class="row float-right" style="margin-right: 10px">
            <h6><i class="fas fa-info"></i><b>&nbsp; Attenzione:</b>
            Puoi annullare la prenotazione entro {{$giorni_di_differenza-14}} giorni.</h6>
        {!! Form::open(['action' => ['PrenotazioneClienteController@destroy', $prenotazione->id], 'method' => 'POST', 'class' =>
        'float-right', 'style' => "margin-left: 20px"]) !!}
        {{ Form::hidden('_method', 'DELETE') }}
        {{ Form::submit('Annulla', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Confermi di voler annullare questa prenotazione?')"]) }}
        {!! Form::close() !!}
        </div>
    @endif
    <hr>

@endsection
