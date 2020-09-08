@extends('layouts.app')

<title> Thousand Sunny B&B | Dipendenti </title>

@section('thousand_sunny_content')
<a href="/dipendenti" class="btn btn-outline-secondary" style="margin-left: 10px">Indietro</a>
<br>
<br>
{!! Form::open(['action' => ['DipendenteController@update', $dipendente->user_id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="col-12">
    <!-- Custom Tabs -->
    <div class="card">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Modifica un dipendente</h3>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('nome', 'Nome')}}}
                                {{{Form::text('nome', $dipendente->utente->name, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('cognome', 'Cognome')}}}
                                {{{Form::text('cognome', $dipendente->utente->cognome, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('data_nascita', 'Data di nascita')}}}
                                {{{Form::date('data_nascita', $dipendente->utente->data_nascita, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('luogo_nascita', 'Luogo di nascita')}}}
                                {{{Form::text('luogo_nascita', $dipendente->utente->luogo_nascita, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('indirizzo', 'Indirizzo')}}}
                                {{{Form::text('indirizzo', $dipendente->utente->indirizzo, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('telefono', 'Telefono')}}}
                                {{{Form::text('telefono', $dipendente->utente->telefono, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('email', 'Email')}}}
                                {{{Form::text('email', $dipendente->utente->email, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('tipo_contratto', 'Tipo contratto')}}}
                                {{{Form::select('tipo_contratto', $dipendente_tipo_contratto_enum, $dipendente->tipo_contratto, [ 'class' => 'form-control', 'placeholder' => 'Seleziona un tipo di contratto' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('ruolo', 'Ruolo')}}}
                                {{{Form::select('ruolo', $dipendente_ruolo_enum, $dipendente->ruolo, [ 'class' => 'form-control', 'placeholder' => 'Seleziona un ruolo' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('data_inizio', 'Data inizio')}}}
                                {{{Form::date('data_inizio', $dipendente->data_inizio, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('data_fine', 'Data fine')}}}
                                {{{Form::date('data_fine', $dipendente->data_fine, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('ore_settimanali', 'Ore settimanali')}}}
                                {{{Form::number('ore_settimanali', $dipendente->ore_settimanali, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('stipendio', 'Stipendio')}}}
                                {{{Form::text('stipendio', $dipendente->stipendio, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('iban', 'IBAN')}}}
                                {{{Form::text('iban', $dipendente->iban, [ 'class' => 'form-control' ])}}}
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