@extends('layouts.app')

@section('thousand_sunny_content')
<div class="col-md-12">
    <div class="card card-primary card-outline">
        <div class="card-header d-flex p-0">
            <h5 class="card-title p-3">Riepilogo prenotazione</h5>
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
                <div class="col-md-2"><b>Attività selezionate</b></div>
                <div class="col-md-10 col-md-offset-1">
                    @foreach($prenotazione->attivita as $singola_attivita)
                        <li>{{\Carbon\Carbon::parse($singola_attivita->data)->format("d/m/Y") }}  -  {{ \Carbon\Carbon::parse($singola_attivita->ora)->format("H:i") }}  |  {{ $singola_attivita->destinazione }}  |  {{ $singola_attivita->tipologia }}</li>
                    @endforeach
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-2"><b>Importo totale:</b></div>
                <div class="col-md-offset-1">{{ $prenotazione->importo }} €</div>
            </div>
        </div>
    </div>
    <button onclick="elimina({{$prenotazione->id}})" data-toggle="tooltip" data-placement="top" class="btn btn-danger">Annulla prenotazione</button>
    @if($prenotazione->metodo_pagamento == 'Pagamento in struttura')
        <button onclick="conferma({{$prenotazione->id}})"  class="btn btn-primary float-right" style="margin-left: 10px">Conferma prenotazione</a>
    @else
        <button type="button" name="paga" data-target="#paga" data-toggle="modal" class="btn btn-primary float-right" value="{{$prenotazione->id}}"><i class="fas fa-credit-card" style="margin-right: 10px"></i>Paga ora</button>
    @endif
</div>

<div class="modal fade bd-example-modal-sm" id="paga" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" >
            <form id="formPagamento">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="exampleModalLabel">Pagamento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="card-body">
                    <div class="row" style="margin-bottom: 15px">
                        <div class="input-group col-12">
                            <input type="tel" pattern="[0-9]*" title="Il campo deve contenere solo numeri" minlength="13" maxlength="16" class="form-control" placeholder="Numero carta" autocomplete="cc-number" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-credit-card"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group col-6">
                            <input type="tel" pattern="[0-1][0-9]/2[0-9]" title="MM/AA" class="form-control" placeholder="MM / AA" autocomplete="cc-exp" inputmode="numeric" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-calendar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group col-6">
                            <input type="tel" pattern="[0-9]*" title="Il campo deve contenere solo numeri" minlength="3" maxlength="3" class="form-control" placeholder="CVC" autocomplete="off" inputmode="numeric" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" value="{{$prenotazione->id}}">
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Paga {{$prenotazione->importo}} €</button></div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
    <script>
        var id_level = {!! json_encode(\Auth::user()->id_level) !!};
        
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
                            if(id_level == 0)
                                window.location.replace('/prenotazioni');
                            else
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

        function conferma(id) {
            alert('Prenotazione avvenuta con successo!');
            if(id_level == 0)
                window.location.replace('/prenotazioni/'+<?php echo $prenotazione->id ?>);
            else
                window.location.replace('/prenotazioni_cliente/'+<?php echo $prenotazione->id ?>);
        }

        $(document).ready(function() {
            var formPagamento = $('#formPagamento');
            formPagamento.submit(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/prenotazioni/pagamento',
                    data: formPagamento.serialize(),
                    success: function (data) {
                        console.log(data);
                        if(data){
                            console.log('Submission was successful.');
                            alert("Pagamento effettuato con successo!");
                            if(id_level == 0)
                                window.location.replace('/prenotazioni/'+<?php echo $prenotazione->id ?>);
                            else
                                window.location.replace('/prenotazioni_cliente/'+<?php echo $prenotazione->id ?>);
                        }else{
                            alert(data);
                        }
                    },
                    error: function (data) {
                        console.log('An error occurred.');
                        console.log(data);
                        alert("Errore! Pagamento annullato");
                    },
                });
            });
        });
    </script>
@stop
 