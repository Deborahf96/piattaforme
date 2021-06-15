@extends('layouts.app')

@section('thousand_sunny_content')
    <div class="card card-primary card-outline">
        <div class="card-header d-flex p-0">
            <h5 class="card-title p-3">@if(Auth::user()->id_level == 0) Cliente @else Profilo @endif</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"><b>Nome completo</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $cliente->utente->name }}</div>
                <div class="col-md-2"><b>Data di nascita</b></div>
                <div class="col-md-3 col-md-offset-1">{{ isset($cliente->utente->data_nascita) ? $cliente->utente->data_nascita : '-' }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Luogo di nascita</b></div>
                <div class="col-md-3 col-md-offset-1">{{ isset($cliente->utente->luogo_nascita) ? $cliente->utente->luogo_nascita : '-' }}</div>
                <div class="col-md-2"><b>Indirizzo</b></div>
                <div class="col-md-3 col-md-offset-1">{{ isset($cliente->utente->indirizzo) ? $cliente->utente->indirizzo : '-' }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Telefono</b></div>
                <div class="col-md-3 col-md-offset-1">{{ isset($cliente->utente->telefono) ? $cliente->utente->telefono : '-' }}</div>
                <div class="col-md-2"><b>Email</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $cliente->utente->email }}</div>
            </div>
        </div>
    </div>
    @if(Auth::user()->id_level == 0)
        <a href="/clienti/{{ $cliente->user_id }}/prenotazioni" class="btn btn-info" style="margin-right: 10px">Visualizza prenotazioni</a>
    @else
        <a href="/cliente/edit" class="btn btn-primary" style="margin-right: 10px">Modifica profilo</a>
        <a href="/modifica_password" class="btn btn-primary" style="margin-right: 10px">Modifica password</a>
        <button onclick="elimina()" data-toggle="tooltip" data-placement="top" title="Elimina" class="btn btn-danger float-right">Elimina</button>
    @endif
</div>
@stop

@section('js')
    <script>
        function elimina() {
            if(confirm('Sei sicuro di voler eliminare questo account?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/cliente/elimina',
                    success: function(data) {
                        console.log(data);
                        if(data) {
                            alert('Account eliminato con successo!');
                            window.location.replace('/about_us');
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        alert("Errore! Non è possibile eliminare l'account'!");
                    },
                });
            }
        }
    </script>
@stop