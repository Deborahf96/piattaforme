@extends('layouts.app')

@section('thousand_sunny_content')
    @php $azione = $prenotazione->check_pernottamento == 'Confermato' ? 'Annulla pernottamento' : 'Conferma pernottamento'; @endphp
    @php $button = $prenotazione->check_pernottamento == 'Confermato' ? 'fas fa-times' : 'fas fa-check'; @endphp
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header d-flex p-0">
                <h5 class="card-title p-3">Prenotazione</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2"><b>Cliente</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ isset($prenotazione->cliente) ? $prenotazione->cliente : $cliente_name }}</div>
                    <div class="col-md-2"><b>Camera</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->camera->numero }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Data check-in</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ \Carbon\Carbon::parse($prenotazione->data_checkin)->format('d/m/Y') }}</div>
                    <div class="col-md-2"><b>Data check-out</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ \Carbon\Carbon::parse($prenotazione->data_checkout)->format('d/m/Y') }}</div>
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
                    <div class="col-md-3 col-md-offset-1">{{ $prenotazione->check_pernottamento }}
                    <button onclick="check({{$prenotazione->id}},'{{$prenotazione->check_pernottamento}}')" data-toggle="tooltip" data-placement="top" title="{{$azione}}" class="btn btn-warning float-right" style="margin-right: 10px"><i class="{{$button}}"></i></button>
                </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Attività selezionate</b></div>
                    <div class="col-md-10 col-md-offset-1">
                        @foreach ($prenotazione->attivita as $singola_attivita)
                            <li><a href="/attivita/{{$singola_attivita->id}}" class="btn btn-link">
                                {{ \Carbon\Carbon::parse($singola_attivita->data)->format("d/m/Y") }}  -  {{ \Carbon\Carbon::parse($singola_attivita->ora)->format("H:i") }}  |  {{ $singola_attivita->destinazione }}  |  {{ $singola_attivita->tipologia }}
                            </a></li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @if($prenotazione->cliente == null)
            <a href="/clienti/{{ $prenotazione->cliente_user_id }}"  class="btn btn-info" style="margin-right: 10px">Visualizza profilo cliente</a>
        @endif
        <!--button type="button" class="btn btn-info disabled" style="margin-right: 10px">Visualizza fattura</button-->
        <button onclick="elimina({{$prenotazione->id}})" data-toggle="tooltip" data-placement="top" title="Annulla" class="btn btn-danger float-right">Annulla</button>
    </div>
@stop

@section('js')
    <script>
        function elimina(id) {
            if(confirm('Sei sicuro di voler annullare questa prenotazione?')) {
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
                            window.location.replace('/prenotazioni');
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        alert('Errore! Non è possibile annullare la prenotazione!');
                    },
                });
            }
        }

        function check(id, check_pernottamento) {
            var azione = (check_pernottamento == 'Confermato') ? 'annullare' : 'confermare';
            if(confirm('Sei sicuro di voler '+azione+' il pernottamento di questa prenotazione?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/prenotazioni/check',
                    data: { 'id': id },
                    success: function(data) {
                        console.log(data);
                        if(data) {
                            alert('Prenotazione aggiornata con successo!');
                            window.location.reload();
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        alert('Errore! Non è possibile aggiornare la prenotazione!');
                    },
                });
            }
        }
    </script>
@stop
