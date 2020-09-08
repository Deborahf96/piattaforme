@extends('layouts.app')

<title> Thousand Sunny B&B | Prenotazioni </title>

@section('thousand_sunny_content')
<a href="/prenotazioni/{{$prenotazione->id}}" class="btn btn-outline-secondary" style="margin-left: 10px">Indietro</a>
<br>
<br>
<div class="col-md-4">
    <div class="form-group" div style = 'text-align: right'>
        {{{Form::label('check_pernottamento', 'Conferma avvenuto pernottamento')}}}
        {{{Form::checkbox('check_pernottamento', true, $prenotazione->check_pernottamento, [ 'class' => 'form-control' ])}}}
        
        Si {!! Form::checkbox('check_pernottamento', 'si', true) !!}
        No {!! Form::checkbox('check_pernottamento', 'no') !!}
        {!! Form::submit('invia') !!}

    </div>
</div>

<form action="">
    <div class="icheckbox_flat-green disabled" div style = 'text-align: right'>
        <input name="html" type="checkbox" value="html" />
        <label>
            Conferma avvenuto pernottamento
        </label>
        <div class="col-md-3 col-md-offset-1">{{ $prenotazione->check_pernottamento }}</div>
    </div>
</form>

{!! Form::open(['action' => ['PrenotazioneController@update', $prenotazione->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="col-12">
    <!-- Custom Tabs -->
    <div class="card">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Modifica una prenotazione</h3>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('camera_numero', 'Camera')}}}
                                {{{Form::select('camera_numero', $camere, $prenotazione->camera_numero, [ 'class' => 'form-control', 'placeholder' => 'Seleziona una camera' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('data_checkin', 'Data check-in')}}}
                                {{{Form::date('data_checkin', $prenotazione->data_checkin, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('data_checkout', 'Data check-out')}}}
                                {{{Form::date('data_checkout', $prenotazione->data_checkout, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('cliente', 'Nuovo cliente')}}}
                                {{{Form::text('cliente', $prenotazione->cliente, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('num_persone', 'Numero di persone')}}}
                                {{{Form::number('num_persone', $prenotazione->num_persone, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('metodo_pagamento', 'Metodo di pagamento')}}}
                                {{{Form::select('metodo_pagamento', $metodo_pagamento_enum, $prenotazione->metodo_pagamento, [ 'class' => 'form-control', 'placeholder' => 'Seleziona un metodo di pagamento' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('cliente_user_id', 'Cliente già registrato')}}}
                                {{{Form::select('cliente_user_id', $clienti, $prenotazione->cliente_user_id, [ 'class' => 'form-control', 'placeholder' => 'Seleziona un cliente già registrato' ])}}}
                            </div>
                        </div>
                    </div>
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div><!-- /.card-body -->
    </div>
</div>

{{ Form::hidden('_method','PUT' )}}
{{ Form::submit('Conferma', [ 'class' => 'btn btn-primary float-right', 'style' => 'margin-right: 10px']) }}
{!! Form::close() !!}
@endsection