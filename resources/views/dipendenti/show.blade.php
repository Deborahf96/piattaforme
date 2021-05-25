@extends('layouts.app')

@section('thousand_sunny_content')
    <div class="col-12">
        <a href="/dipendenti" class="btn btn-outline-secondary">Torna a dipendenti</a>
        <hr>
        <div class="row">
            <div class="col-md-5 d-flex align-items-stretch">
                <div class="card card-primary card-outline" style="width: 100%">
                    <div class="card-header d-flex p-0">
                        <h5 class="card-title p-3">Dipendente</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5"><b>Nome completo</b></div>
                            <div class="col-md-7 col-md-offset-1">{{ $dipendente->utente->name }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5"><b>Data di nascita</b></div>
                            <div class="col-md-7 col-md-offset-1">{{ \Carbon\Carbon::parse($dipendente->utente->data_nascita)->format('d/m/Y') }}</div>
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
                                        <div class="col-md-9 col-md-offset-1">{{ $dipendente->tipo_contratto }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Stipendio</b></div>
                                        <div class="col-md-9 col-md-offset-1">{{ $dipendente->stipendio }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Data inizio</b></div>
                                        <div class="col-md-9 col-md-offset-1">{{ \Carbon\Carbon::parse($dipendente->data_inizio)->format('d/m/Y') }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Data fine</b></div>
                                        <div class="col-md-9 col-md-offset-1">{{ isset($dipendente->data_fine) ? \Carbon\Carbon::parse($dipendente->data_fine)->format('d/m/Y') : '-' }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Ruolo</b></div>
                                        <div class="col-md-9 col-md-offset-1">{{ $dipendente->ruolo }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Ore settimanali</b></div>
                                        <div class="col-md-9 col-md-offset-1">{{ $dipendente->ore_settimanali }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>IBAN</b></div>
                                        <div class="col-md-9 col-md-offset-1">{{ $dipendente->iban }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="/dipendenti/{{ $dipendente->user_id }}/edit" class="btn btn-primary" style="margin-right: 10px">Modifica</a>
        <button type="button" class="btn btn-info disabled" style="margin-right: 10px">Visualizza turni</button>
        <button type="button" class="btn btn-info disabled" style="margin-right: 10px">Visualizza piano ferie</button>
        <button type="button" class="btn btn-info disabled">Visualizza buste paga</button>
        <button onclick="elimina({{$dipendente->user_id}})" data-toggle="tooltip" data-placement="top" title="Elimina" class="btn btn-danger float-right">Elimina</button>
        <hr>
    </div>
@stop

@section('js')
    <script>
        function elimina(user_id) {
            if(confirm('Confermi di voler eliminare il dipendente?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/dipendenti/elimina',
                    data: { 'user_id': user_id },
                    success: function(data) {
                        console.log(data);
                        if(data) {
                            alert('Dipendente eliminato con successo!');
                            window.location.replace('/dipendenti');
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        alert('Errore! Non è possibile eliminare il dipendente!');
                    },
                });
            }
        }
    </script>
@stop