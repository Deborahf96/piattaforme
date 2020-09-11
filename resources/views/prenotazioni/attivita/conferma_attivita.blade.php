@extends('layouts.app')

@section('thousand_sunny_content')
<a href="{{ URL::previous() }}" class="btn btn-outline-secondary" style="margin-left: 10px">Indietro</a>
<br>
<br>
<div class="col-md-12 d-flex align-items-stretch">
    <div class="card card-primary card-outline" style="width: 100%">
        <div class="card-header">
            <h5 class="card-title m-0"><b>Inserisci dati prenotazione</b></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"><b>Cliente</b></div>
                <div class="col-md-3 col-md-offset-1">
                    {{ isset($prenotazione->cliente) ? $prenotazione->cliente : $cliente_name }}
                </div>
                <div class="col-md-2"><b>Camera</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $prenotazione->camera_numero }}</div>
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


<br>
<br>
<a href="/prenotazioni/{{$prenotazione->id}}" class="btn btn-primary float-right" style="margin-left: 10px">Conferma prenotazione</a>

@endsection 