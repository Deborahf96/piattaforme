@extends('layouts.app')

@section('thousand_sunny_content')
<div class="col-md-12">
    <a href="{{ URL::previous() }}" class="btn btn-outline-secondary">Indietro</a>
    <br>
    <br>
    <div class="card card-primary card-outline">
        <div class="card-header d-flex p-0">
            <h5 class="card-title p-3">Camera</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 d-flex">
                    @if($camera->path_foto==null)
                        <img class="img-circle elevation-2" src="../../img/camere/default.png" alt="Immagine" style="width: 350px; margin: auto">
                    @else
                        <img class="img-circle elevation-2" src="../../img/camere/{{$camera->path_foto}}" alt="Immagine" style="width: 350px; margin: auto">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-2"><b>Numero</b></div>
                        <div class="col-md-3 col-md-offset-1">{{ $camera->numero }}</div>
                        <div class="col-md-2"><b>Piano</b></div>
                        <div class="col-md-3 col-md-offset-1">{{ $camera->piano }}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-2"><b>Posti letto</b></div>
                        <div class="col-md-3 col-md-offset-1">{{ $camera->numero_letti }}</div>
                        <div class="col-md-2"><b>Costo a notte</b></div>
                        <div class="col-md-3 col-md-offset-1">{{ $camera->costo_a_notte }} €</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-2"><b>Descrizione</b></div>
                        <div class="col-md-8 col-md-offset-1">{{ $camera->descrizione }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($dipendente_check)
        <a href="/camere/{{$camera->id}}/edit" class="btn btn-primary" style="margin-right: 10px">Modifica</a>
        @if($pren_camera_num)
            <a href="/prenotazioni/{{$prenotazione_id}}" class="btn btn-primary" style="margin-right: 10px">Visualizza prenotazione attuale</a>
        @else
            <button type="button" class="btn btn-info disabled">Visualizza prenotazione attuale</button>
        @endif
        <button onclick="elimina({{$camera->id}},{{$camera->numero}})" data-toggle="tooltip" data-placement="top" title="Elimina" class="btn btn-danger float-right">Elimina</button>
    <hr>
    @endif
</div>
@stop

@section('js')
    <script>
        function elimina(id, numero) {
            if(confirm('Confermi di voler eliminare la camera N°'+numero+'?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/camere/elimina',
                    data: { 'id': id },
                    success: function(data) {
                        console.log(data);
                        if(data) {
                            alert('Camera eliminata con successo!');
                            window.location.replace('/camere');
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        alert('Errore! Non è possibile eliminare la camera!');
                    },
                });
            }
        }
    </script>
@stop