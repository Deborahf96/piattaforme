@extends('layouts.app')

<title> Thousand Sunny B&B | Dipendenti </title>

@section('thousand_sunny_content')
    <a href="/dipendenti" class="btn btn-outline-secondary">Torna a dipendenti</a>
    <hr>
    <div class="col-12">
        <div class="card">
            <div class="row">
                <div class="col-md-5 d-flex align-items-stretch">
                    <div class="card card-primary card-outline" style="width: 100%">
                        <div class="card-header">
                            <h5 class="card-title m-0"><b>Dipendente</b></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5"><b>Nome completo</b></div>
                                <div class="col-md-7 col-md-offset-1">{{ $dipendente->utente->name }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-5"><b>Data di nascita</b></div>
                                <div class="col-md-7 col-md-offset-1">
                                    {{ \Carbon\Carbon::parse($dipendente->utente->data_nascita)->format('d/m/Y') }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-5"><b>Luogo di nascita</b></div>
                                <div class="col-md-7 col-md-offset-1">{{ $dipendente->utente->luogo_nascita }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-5"><b>Indirizzo</b></div>
                                <div class="col-md-7 col-md-offset-1">{{ $dipendente->utente->indirizzo }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-5"><b>Telefono</b></div>
                                <div class="col-md-7 col-md-offset-1">{{ $dipendente->utente->telefono }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-5"><b>Email</b></div>
                                <div class="col-md-7 col-md-offset-1">{{ $dipendente->utente->email }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-7 d-flex align-items-stretch">
                    <!-- Custom Tabs -->
                    <div class="card card-primary card-outline" style="width: 100%">
                        <div class="card-header">
                            <h5 class="card-title m-0"><b>Dati contrattuali</b></h5>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="callout callout-info">
                                                <div class="row">
                                                    <div class="col-md-3"><b>Tipo contratto</b></div>
                                                    <div class="col-md-9 col-md-offset-1">
                                                        {{ $dipendente->tipo_contratto }}</div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-3"><b>Stipendio</b></div>
                                                    <div class="col-md-9 col-md-offset-1">
                                                        {{ $dipendente->stipendio }}</div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-3"><b>Data inizio</b></div>
                                                    <div class="col-md-9 col-md-offset-1">
                                                        {{ \Carbon\Carbon::parse($dipendente->data_inizio)->format('d/m/Y') }}
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-3"><b>Data fine</b></div>
                                                    <div class="col-md-9 col-md-offset-1">
                                                        {{ isset($dipendente->data_fine) ? \Carbon\Carbon::parse($dipendente->data_fine)->format('d/m/Y') : '-' }}
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-3"><b>Ruolo</b></div>
                                                    <div class="col-md-9 col-md-offset-1">
                                                        {{ $dipendente->ruolo }}</div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-3"><b>Ore settimanali</b></div>
                                                    <div class="col-md-9 col-md-offset-1">
                                                        {{ $dipendente->ore_settimanali }}</div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-3"><b>IBAN</b></div>
                                                    <div class="col-md-9 col-md-offset-1">
                                                        {{ $dipendente->iban }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div><!-- ./card -->
                </div>
            </div>
        </div>
    </div>

    <a href="/dipendenti/{{ $dipendente->user_id }}/edit" class="btn btn-primary">Modifica</a>
    <a class="btn btn-info">Visualizza turni</a>
    <a class="btn btn-info">Visualizza piano ferie</a>
    <a class="btn btn-info">Visualizza buste paga</a>
    {!! Form::open(['action' => ['DipendenteController@destroy', $dipendente->user_id], 'method' => 'POST', 'class' =>
    'float-right']) !!}
    {{ Form::hidden('_method', 'DELETE') }}
    {{ Form::submit('Elimina', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Confermi di voler eliminare questo dipendente? ')"]) }}
    {!! Form::close() !!}
    <hr>


@endsection
