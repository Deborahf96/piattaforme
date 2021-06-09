@extends('layouts.app')

@section('thousand_sunny_content')
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header d-flex p-0">
                <h5 class="card-title p-3">Prenotazione</h5>
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
                        @foreach($prenotazione->attivita as $singola_attivita)
                            <li>{{ \Carbon\Carbon::parse($singola_attivita->data)->format("d/m/Y") }}  -  {{ \Carbon\Carbon::parse($singola_attivita->ora)->format("H:i") }}  |  {{ $singola_attivita->destinazione }}  |  {{ $singola_attivita->tipologia }}</li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <a href="/camere/{{$prenotazione->camera->numero}}"  class="btn btn-info" style="margin-right: 10px">Visualizza caratteristiche camera</a>
        <button type="button" class="btn btn-info disabled" style="margin-right: 10px">Visualizza fattura</button>

        @php $giorni_di_differenza = (\Carbon\Carbon::now()->diffinDays(\Carbon\Carbon::parse($prenotazione->data_checkout), false)) @endphp
        @if($giorni_di_differenza>=14)
            <div class="row float-right">
                <h6><i class="fas fa-exclamation"></i><b>&nbsp; Attenzione: </b>Puoi annullare la prenotazione entro {{$giorni_di_differenza-14}} giorni.</h6>
                <button onclick="elimina({{$prenotazione->id}})" data-toggle="tooltip" data-placement="top" title="Annulla" class="btn btn-danger float-right" style="margin-right: 10px; margin-left: 10px">Annulla</button>
            </div>
        @endif
    </div>
@stop

@section('js')
    <script>
        function elimina(id) {
            if(confirm('Confermi di voler annullare questa prenotazione?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/prenotazioni/elimina',
                    data: { 'id': id },
                    success: function(data) {
                        console.log(data);
                        if(data) {
                            alert('Prenotazione annullata con successo!');
                            window.location.replace('/prenotazioni_cliente');
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        alert('Errore! Non è possibile annullare la prenotazione!');
                    },
                });
            }
        }
    </script>
@stop

