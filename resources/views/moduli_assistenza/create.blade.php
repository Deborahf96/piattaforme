@extends('layouts.app')

@section('thousand_sunny_content')
<a href="/moduli_assistenza" class="btn btn-outline-secondary" style="margin-left: 10px">Indietro</a>
<br>
<br>
{!! Form::open(['action' => ['ModuloAssistenzaController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="col-12">
    <!-- Custom Tabs -->
    <div class="card">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Richiedi informazioni/Invia un reclamo</h3>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{{Form::label('tipologia', 'Tipologia di assistenza')}}}
                                {{{Form::select('tipologia', $assistenza_tipologia_enum, '', [ 'class' => 'form-control', 'placeholder' => 'Seleziona una tipologia di assistenza' ])}}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{{Form::label('oggetto', 'Oggetto')}}}
                                {{{Form::text('oggetto', '', [ 'class' => 'form-control' ])}}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{{Form::label('messaggio', 'Messaggio')}}}
                                {{{Form::textarea('messaggio', '', [ 'class' => 'form-control', 'placeholder' => 'Inserisci un messaggio ...' ])}}}
                            </div>
                        </div>
                    </div>
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div><!-- /.card-body -->
    </div>
</div>

{{ Form::submit('Invia', [ 'class' => 'btn btn-primary float-right', 'style' => 'margin-right: 10px']) }}
{!! Form::close() !!}
@endsection