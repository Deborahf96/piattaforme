@extends('layouts.app')

@section('thousand_sunny_content')
<div class="col-md-12">
    <div class="card card-primary card-outline">
        <div class="card-header d-flex p-0">
            <h5 class="card-title p-3">Attività</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"><b>Ditta esterna</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $attivita->ditta_esterna->nome }}</div>
                <div class="col-md-2"><b>Tipologia</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $attivita->tipologia }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Data</b></div>
                <div class="col-md-3 col-md-offset-1">{{ \Carbon\Carbon::parse($attivita->data)->format('d/m/Y') }}</div>
                <div class="col-md-2"><b>Ora</b></div>
                <div class="col-md-3 col-md-offset-1">{{ \Carbon\Carbon::parse($attivita->ora)->format('H:i') }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Luogo di destinazione</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $attivita->destinazione }}</div>
                <div class="col-md-2"><b>Costo</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $attivita->costo }} €</div>
            </div>
        </div>
    </div>
    @php $ditta = $attivita->ditta_esterna->partita_iva @endphp
    <a href="/attivita/{{ $attivita->id }}/edit" class="btn btn-primary" style="margin-right: 10px">Modifica</a>
    <a href="/ditte_esterne/{{ $ditta }}"  class="btn btn-info">Visualizza ditta esterna</a>
    <button onclick="elimina({{$attivita->id}})" data-toggle="tooltip" data-placement="top" title="Elimina" class="btn btn-danger float-right">Elimina</button>
</div>
@stop

@section('js')
    <script>
        function elimina(id) {
            if(confirm("Sei sicuro di voler eliminare l'attività'?")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/attivita/elimina',
                    data: { 'id': id },
                    success: function(data) {
                        console.log(data);
                        if(data) {
                            alert('Attività eliminata con successo!');
                            window.location.replace('/attivita');
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        alert("Errore! Non è possibile eliminare l'attivita!");
                    },
                });
            }
        }
    </script>
@stop