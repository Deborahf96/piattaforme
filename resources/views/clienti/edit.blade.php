@extends('layouts.app')

@section('thousand_sunny_content')
<a href="/clienti/{{$cliente->user_id}}/show" class="btn btn-outline-secondary" style="margin-left: 10px">Indietro</a>
<br>
<br>
{!! Form::open(['action' => ['ClienteController@update', $cliente->user_id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="col-12">
    <!-- Custom Tabs -->
    <div class="card">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Modifica profilo</h3>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('nome', 'Nome')}}}
                                {{{Form::text('nome', $cliente->utente->name, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('cognome', 'Cognome')}}}
                                {{{Form::text('cognome', $cliente->utente->cognome, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('data_nascita', 'Data di nascita')}}}
                                {{{Form::date('data_nascita', $cliente->utente->data_nascita, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('luogo_nascita', 'Luogo di nascita')}}}
                                {{{Form::text('luogo_nascita', $cliente->utente->luogo_nascita, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('indirizzo', 'Indirizzo')}}}
                                {{{Form::text('indirizzo', $cliente->utente->indirizzo, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('telefono', 'Telefono')}}}
                                {{{Form::text('telefono', $cliente->utente->telefono, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('email', 'Email')}}}
                                {{{Form::text('email', $cliente->utente->email, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('metodo_pagamento', 'Metodo di pagamento')}}}
                                {{{Form::select('metodo_pagamento', $cliente_metodo_pagamento_enum, $cliente->metodo_pagamento, [ 'class' => 'form-control', 'placeholder' => 'Seleziona un metodo di pagamento' ])}}}
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