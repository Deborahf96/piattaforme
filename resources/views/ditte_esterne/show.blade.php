@extends('layouts.app')

@section('thousand_sunny_content')
    <div class="col-12">
        <div class="row">
            <div class="col-md-5 d-flex align-items-stretch">
                <div class="card card-primary card-outline" style="width: 100%">
                    <div class="card-header d-flex p-0">
                        <h5 class="card-title p-3">Ditta esterna</h5>
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
                            <div class="col-md-5"><b>Categoria</b></div>
                            <div class="col-md-7 col-md-offset-1">{{ $ditta_esterna->categoria }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><b>Descrizione</b></div>
                            <div class="col-md-7 col-md-offset-1">{{ isset($ditta_esterna->descrizione) ? $ditta_esterna->descrizione : '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-7 d-flex align-items-stretch">
                <div class="card card-primary card-outline" style="width: 100%">
                    <div class="card-header d-flex p-0">
                        <h5 class="card-title p-3">Dati contrattuali</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="callout callout-info">
                                    <div class="row">
                                        <div class="col-md-3"><b>Tipo contratto</b></div>
                                        <div class="col-md-9 col-md-offset-1">{{ $ditta_esterna->tipo_contratto }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Paga</b></div>
                                        <div class="col-md-9 col-md-offset-1">{{ $ditta_esterna->paga }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Data inizio</b></div>
                                        <div class="col-md-9 col-md-offset-1">{{ \Carbon\Carbon::parse($ditta_esterna->data_inizio)->format('d/m/Y') }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Data fine</b></div>
                                        <div class="col-md-9 col-md-offset-1">{{ isset($ditta_esterna->data_fine) ? \Carbon\Carbon::parse($ditta_esterna->data_fine)->format('d/m/Y') : '-' }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>IBAN</b></div>
                                        <div class="col-md-9 col-md-offset-1">{{ $ditta_esterna->iban }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="/ditte_esterne/{{ $ditta_esterna->partita_iva }}/edit" class="btn btn-primary" style="margin-right: 10px">Modifica</a>
        <!--button type="button" class="btn btn-info disabled" style="margin-right: 10px">Visualizza attività</button-->
        <button onclick="elimina({{$ditta_esterna->id}})" data-toggle="tooltip" data-placement="top" title="Elimina" class="btn btn-danger float-right">Elimina</button>
    </div>
@stop

@section('js')
    <script>
        function elimina(id) {
            if(confirm('Sei sicuro di voler eliminare la ditta?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/ditte_esterne/elimina',
                    data: { 'id': id },
                    success: function(data) {
                        console.log(data);
                        if(data) {
                            alert('Ditta eliminata con successo!');
                            window.location.replace('/ditte_esterne');
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        alert('Errore! Non è possibile eliminare la ditta!');
                    },
                });
            }
        }
    </script>
@stop