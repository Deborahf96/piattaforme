@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/ditte_esterne" class="btn btn-outline-secondary">Torna a ditte</a>
    <hr>
    <div class="col-12">
        <div class="card">
            <div class="row">
                <div class="col-md-5 d-flex align-items-stretch">
                    <div class="card card-primary card-outline" style="width: 100%">
                        <div class="card-header">
                            <h5 class="card-title m-0"><b>Ditta esterna</b></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5"><b>Partita IVA</b></div>
                                <div class="col-md-7 col-md-offset-1">{{ $ditta_esterna->partita_iva }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-5"><b>Nome</b></div>
                                <div class="col-md-7 col-md-offset-1">{{ $ditta_esterna->nome }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-5"><b>Indirizzo</b></div>
                                <div class="col-md-7 col-md-offset-1">{{ $ditta_esterna->indirizzo }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-5"><b>Telefono</b></div>
                                <div class="col-md-7 col-md-offset-1">{{ $ditta_esterna->telefono }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-5"><b>Email</b></div>
                                <div class="col-md-7 col-md-offset-1">{{ $ditta_esterna->email }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-5"><b>IBAN</b></div>
                                <div class="col-md-7 col-md-offset-1">{{ $ditta_esterna->iban }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-5"><b>Categoria</b></div>
                                <div class="col-md-7 col-md-offset-1">{{ $ditta_esterna->categoria }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-7 d-flex align-items-stretch">
                    <!-- Custom Tabs -->
                    <div class="card card-primary card-outline" style="width: 100%">
                        <div class="card-header d-flex p-0">
                            <h3 class="card-title p-3"></h3>
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Dati
                                        contrattuali</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="callout callout-info">
                                                <div class="row">
                                                    <div class="col-md-3"><b>Tipo contratto</b></div>
                                                    <div class="col-md-9 col-md-offset-1">
                                                        {{ $ditta_esterna->tipo_contratto }}</div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-3"><b>Paga</b></div>
                                                    <div class="col-md-9 col-md-offset-1">
                                                        {{ $ditta_esterna->paga }}</div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-3"><b>Data inizio</b></div>
                                                    <div class="col-md-9 col-md-offset-1">
                                                        {{ \Carbon\Carbon::parse($ditta_esterna->data_inizio)->format('d/m/Y') }}</div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-3"><b>Data fine</b></div>
                                                    <div class="col-md-9 col-md-offset-1">
                                                        {{ \Carbon\Carbon::parse($ditta_esterna->data_fine)->format('d/m/Y') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- ./card -->
                </div>
            </div>
        </div>
    </div>

    <a href="/ditte_esterne/{{ $ditta_esterna->partita_iva }}/edit" class="btn btn-primary">Modifica</a>
    {!! Form::open(['action' => ['DittaEsternaController@destroy', $ditta_esterna->partita_iva], 'method' => 'POST', 'class'
    => 'float-right']) !!}
    {{ Form::hidden('_method', 'DELETE') }}
    {{ Form::submit('Elimina', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Confermi di voler eliminare questa ditta? $ditta_esterna->nome ')"]) }}
    {!! Form::close() !!}
    <hr>


@endsection
