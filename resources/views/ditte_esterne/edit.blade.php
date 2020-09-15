@extends('layouts.app')

@section('thousand_sunny_content')
<a href="/ditte_esterne" class="btn btn-outline-secondary" style="margin-left: 10px">Torna a ditte</a>
<br>
<br>
{!! Form::open(['action' => ['DittaEsternaController@update', $ditta_esterna->partita_iva], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="col-12">
    <!-- Custom Tabs -->
    <div class="card">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Modifica una ditta</h3>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('partita_iva', 'Partita IVA')}}}
                                {{{Form::text('partita_iva', $ditta_esterna->partita_iva, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('nome', 'Nome')}}}
                                {{{Form::text('nome', $ditta_esterna->nome, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('indirizzo', 'Indirizzo')}}}
                                {{{Form::text('indirizzo', $ditta_esterna->indirizzo, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('telefono', 'Telefono')}}}
                                {{{Form::text('telefono', $ditta_esterna->telefono, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('email', 'Email')}}}
                                {{{Form::text('email', $ditta_esterna->email, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('iban', 'IBAN')}}}
                                {{{Form::text('iban', $ditta_esterna->iban, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('categoria', 'Categoria')}}}
                                {{{Form::select('categoria', $ditta_esterna_categoria_enum, $ditta_esterna->categoria, [ 'class' => 'form-control', 'placeholder' => 'Seleziona una categoria' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('tipo_contratto', 'Tipo contratto')}}}
                                {{{Form::select('tipo_contratto', $ditta_esterna_tipo_contratto_enum, $ditta_esterna->tipo_contratto, [ 'class' => 'form-control', 'placeholder' => 'Seleziona un tipo di contratto' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('paga', 'Paga')}}}
                                {{{Form::text('paga', $ditta_esterna->paga, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('data_inizio', 'Data inizio')}}}
                                {{{Form::date('data_inizio', $ditta_esterna->data_inizio, [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('data_fine', 'Data fine')}}}
                                {{{Form::date('data_fine', $ditta_esterna->data_fine, [ 'class' => 'form-control' ])}}}
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