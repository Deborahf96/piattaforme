@extends('layouts.app')

<title> Thousand Sunny B&B | Camere </title>

@section('thousand_sunny_content')
<a href="/camere" class="btn btn-outline-secondary" style="margin-left: 10px">Indietro</a>
<br>
<br>
{!! Form::open(['action' => ['CameraController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="col-12">
    <!-- Custom Tabs -->
    <div class="card">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Aggiungi una nuova camera</h3>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('numero', 'Numero')}}}
                                {{{Form::number('numero', '', [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('piano', 'Piano')}}}
                                {{{Form::select('piano', $camera_piano_enum, '', [ 'class' => 'form-control', 'placeholder' => 'Seleziona un piano' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('numero_letti', 'Numero letti')}}}
                                {{{Form::number('numero_letti', '', [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('costo_a_notte', 'Costo a notte')}}}
                                {{{Form::number('costo_a_notte', '', [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{{Form::label('descrizione', 'Descrizione')}}}
                                {{{Form::text('descrizione', '', [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                    </div>
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div><!-- /.card-body -->
    </div>
</div>

{{ Form::submit('Conferma', [ 'class' => 'btn btn-primary float-right', 'style' => 'margin-right: 10px']) }}
{!! Form::close() !!}
@endsection