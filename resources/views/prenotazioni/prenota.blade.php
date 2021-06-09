@extends('layouts.app')

@section('thousand_sunny_content')
    <h1>Effettua una nuova prenotazione</h1>
    <hr>
    <form action="/prenotazioni/prenota" enctype="multipart/form-data" method="GET">
        <div class="d-flex justify-content-start align-items-center">
            <div><h5 style="margin-block-end: 0px"><b>Seleziona</b></h5></div>
            <div style="margin-left: 20px">Data check-in</div>
            <div style="margin-left: 10px"><input type="date" class="form-control" name="data_checkin" id="data_checkin" value="{{$data_checkin}}"></div>
            <div style="margin-left: 10px">Data check-out</div>
            <div style="margin-left: 10px"><input type="date" class="form-control" name="data_checkout" id="data_checkout" value="{{$data_checkout}}"></div>
            <div style="margin-left: 10px">Posti letto</div>
            <div style="margin-left: 10px"><input type="number" min="1" class="form-control" name="num_persone" id="num_persone" value="{{$num_persone}}"></div>
            <button type="submit" class="btn btn-primary" style="margin-left: 20px">Conferma</button>
        </div>
    </form>
    <hr>
    @if(count($camere) > 0)
    <div class="row">
        @foreach ($camere as $camera)
        @php $costo_totale = (\Carbon\Carbon::parse($data_checkin)->diffinDays(\Carbon\Carbon::parse($data_checkout), false))*$camera->costo_a_notte @endphp
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="img-circle" @if($camera->path_foto==null) src="../../img/camere/default.png" @else src="../../img/camere/{{$camera->path_foto}}" @endif alt="Immagine" width="120" height="120">
                        </div>
                        <h3 class="profile-username text-center">Camera {{ $camera->numero }}</h3>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item"><b>Piano</b><a class="float-right">{{ $camera->piano }}</a></li>
                            <li class="list-group-item"><b>Posti letto</b><a class="float-right">{{ $camera->numero_letti }}</a></li>
                            <li class="list-group-item"><b>Costo a notte</b><a class="float-right">{{ $camera->costo_a_notte }} €</a></li>
                            <li class="list-group-item"><b>Costo totale</b><a class="float-right">{{ $costo_totale }} € </a></li>
                        </ul>
                        <a href="/camere/{{ $camera->id }}" class="btn btn-primary btn-block">Caratteristiche</a>
                        <form id="formPrenota" @if(Auth::user()->id_level == 0) action="/prenotazioni/create" @else action="/prenotazioni_cliente/create" @endif method="GET" enctype="multipart/form-data">
                            <input type="hidden" value="{{$camera->numero}}" name="camera_numero" id="camera_numero">
                            <input type="hidden" value="{{$data_checkin}}" name="data_checkin" id="data_checkin">
                            <input type="hidden" value="{{$data_checkout}}" name="data_checkout" id="data_checkout">
                            <input type="hidden" value="{{$num_persone}}" name="num_persone" id="num_persone">
                            <button type="submit" id="prenota" class="btn btn-success btn-block" style="margin-top: 10px">Prenota</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @else
        <p>Nessuna camera disponibile</p>
    @endif
@stop
