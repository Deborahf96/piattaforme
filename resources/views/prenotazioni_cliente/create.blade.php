@extends('layouts.app')

@section('thousand_sunny_content')
<a href="/prenotazioni_cliente/prenota" class="btn btn-outline-secondary" style="margin-left: 10px">Indietro</a>
<br>
<br>
{!! Form::open(['action' => ['PrenotazioneClienteController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="col-md-12 d-flex align-items-stretch">
    <div class="card card-primary card-outline" style="width: 100%">
        <div class="card-header">
            <h5 class="card-title m-0"><b>Inserisci dati prenotazione</b></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"><b>Camera</b></div>
                <div class="col-md-3 col-md-offset-1">
                    {{{ $camera_numero }}}
                    {{{Form::hidden('camera_numero', $camera_numero, [ 'class' => 'form-control' ])}}}
                </div>
                <div class="col-md-2"><b>Posti letto</b></div>
                <div class="col-md-3 col-md-offset-1">
                    {{{ $num_persone }}}
                    {{{Form::hidden('num_persone', $num_persone, [ 'class' => 'form-control' ])}}}
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Data check-in</b></div>
                <div class="col-md-3 col-md-offset-1">
                    {{{ \Carbon\Carbon::parse($data_checkin)->format('d/m/Y') }}}
                    {{{Form::hidden('data_checkin', $data_checkin, [ 'class' => 'form-control' ])}}}
                </div>
                <div class="col-md-2"><b>Data check-out</b></div>
                <div class="col-md-3 col-md-offset-1">
                    {{{ \Carbon\Carbon::parse($data_checkout)->format('d/m/Y') }}}
                    {{{Form::hidden('data_checkout', $data_checkout, [ 'class' => 'form-control' ])}}}
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Metodo di pagamento</b></div>
                <div class="col-md-3">               
                    <div class="d-flex align-items-center">
                    {{{Form::select('metodo_pagamento', $metodo_pagamento_enum, $pagamento_default, [ 'class' => 'form-control', 'placeholder' => 'Seleziona metodo di pagamento' ])}}}
                    </div>
                </div>
                <div class="col-md-2"><b>Importo parziale:</b></div>
                <div class="col-md-3">
                    {{{ $costo_totale }}} €
                    {{{Form::hidden('costo_totale', $costo_totale, [ 'class' => 'form-control' ])}}}
                </div>
            </div>
        </div>
    </div>
</div>

@if (count($attivita) > 0)
    <div class="card card-primary card-outline collapsed-card" style="margin-left: 10px; margin-right: 10px">            
        <div class="card-header">
            <h5 class="card-title m-0"><b>Seleziona attività</b></h5>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                </button>
            </div><!-- /.card-tools -->
        </div><!-- /.card-header -->
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
                    @foreach ($attivita as $singola_attivita)
                        <tr>
                            <td width=15%>
                                {{ $singola_attivita->data }}
                            </td>
                            <td width=15%>
                                {{ \Carbon\Carbon::parse($singola_attivita->ora)->format('H:i') }}
                            </td>
                            <td width=15%>
                                {{ $singola_attivita->destinazione }}
                            </td>
                            <td width=15%>
                                {{ $singola_attivita->tipologia }}
                            </td>
                            <td width=20%>
                                {{ $singola_attivita->costo }} €
                            </td>
                            <td width=20%>
                                <div class="d-flex justify-content-center">
                                    {{ Form::checkbox('attivita[]', $singola_attivita->id) }}
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

<br>
<br>
<a href="{{URL::previous()}}" class="btn btn-outline-secondary" style="margin-left: 10px">Indietro</a>
{{ Form::submit('Avanti', [ 'class' => 'btn btn-primary float-right', 'style' => 'margin-right:10px']) }}
{!! Form::close() !!}

@endsection