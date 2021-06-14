@extends('layouts.app')

@section('thousand_sunny_content')
<form id="formPrenota">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header d-flex p-0">
                <h5 class="card-title p-3">Inserisci dati prenotazione</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2"><b>Camera</b></div>
                    <div class="col-md-3 col-md-offset-1">{{$camera->numero}}</div>
                    <input type="hidden" value="{{$camera->id}}" name="camera_id" id="camera_id">
                    <div class="col-md-2"><b>Posti letto</b></div>
                    <div class="col-md-3 col-md-offset-1">{{$num_persone}}</div>
                    <input type="hidden" value="{{$num_persone}}" name="num_persone" id="num_persone">
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Data check-in</b></div>
                    <div class="col-md-3 col-md-offset-1">{{\Carbon\Carbon::parse($data_checkin)->format('d/m/Y')}}</div>
                    <input type="hidden" value="{{$data_checkin}}" name="data_checkin" id="data_checkin">
                    <div class="col-md-2"><b>Data check-out</b></div>
                    <div class="col-md-3 col-md-offset-1">{{\Carbon\Carbon::parse($data_checkout)->format('d/m/Y')}}</div>
                    <input type="hidden" value="{{$data_checkout}}" name="data_checkout" id="data_checkout">
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Metodo di pagamento</b></div>
                    <div class="col-md-3 d-flex align-items-center">{{{Form::select('metodo_pagamento', $metodo_pagamento_enum, '', [ 'class' => 'form-control', 'placeholder' => 'Seleziona metodo di pagamento', 'required' ])}}}</div>
                    <div class="col-md-2"><b>Importo parziale:</b></div>
                    <div class="col-md-3">{{$costo_totale}} €</div>
                    <input type="hidden" value="{{$costo_totale}}" name="costo_totale" id="costo_totale">
                </div>
            </div>
        </div>
        @if(Auth::user()->id_level == 0)
        <div class="card card-primary card-outline">
            <div class="card-header d-flex p-0">
                <h5 class="card-title p-3">Inserisci dati cliente</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5 form-group">
                        <label for="cliente" class="control-label">Nuovo cliente</label>
                        <input type="text" class="form-control" name="cliente" id="cliente" placeholder="Nome e cognome">
                    </div> 
                    <div class="col-1" style="margin-left: 20px">oppure</div>
                    <div class="col-md-5 form-group">
                        <label for="cliente_user_id" class="control-label">Cliente già registrato</label>
                        {{{Form::select('cliente_user_id', $clienti, '', [ 'class' => 'form-control', 'placeholder' => 'Seleziona un cliente' ])}}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(count($attivita) > 0)
            <div class="card card-primary card-outline collapsed-card">            
                <div class="card-header">
                    <h5 class="card-title m-0">Seleziona attività</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="" class="display table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Ora</th>
                                <th>Destinazione</th>
                                <th>Tipologia</th>
                                <th>Costo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attivita as $singola_attivita)
                                <tr>
                                    <td width=15%>{{$singola_attivita->data}}</td>
                                    <td width=15%>{{\Carbon\Carbon::parse($singola_attivita->ora)->format('H:i')}}</td>
                                    <td width=20%>{{$singola_attivita->destinazione}}</td>
                                    <td width=20%>{{$singola_attivita->tipologia}}</td>
                                    <td width=15%>{{$singola_attivita->costo}} €</td>
                                    <td width=15%>
                                        <div class="d-flex justify-content-center">
                                            <input type="checkbox" name="attivita[]" value="{{$singola_attivita->id}}">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <p>Nessuna attività disponibile</p>
        @endif
        <button type="submit" id="avanti" class="btn btn-primary float-right">Avanti</button>
    </div>
</form>
@stop
    
@section('js')
    <script>
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
         
        $(document).ready(function() {
            var formPrenota = $('#formPrenota');
            formPrenota.submit(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/prenotazioni/prenota-camera',
                    data: formPrenota.serialize(),
                    success: function (data) {
                        console.log(data);
                        if(data!=''){
                            if(data.length > 5)
                                alert(data);
                            else {
                                console.log('Submission was successful.');
                                window.location.replace('/prenotazioni/riepilogo/'+data);
                            }
                        }else{
                            alert(data);
                        }
                    },
                    error: function (data) {
                        console.log('An error occurred.');
                        console.log(data);
                        alert("Impossibile effettuare la prenotazione!");
                    },
                });
            });
        });
    </script>
@stop