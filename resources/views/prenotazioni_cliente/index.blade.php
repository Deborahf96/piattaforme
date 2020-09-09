@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/" class="btn btn-outline-secondary">Indietro</a>
    <br>
    <br>
    <h1>Effettua una nuova prenotazione</h1>
    <hr>

    {!! Form::open(['action' => ['PrenotazioneClienteController@index'], 'method' => 'GET', 'enctype' =>
    'multipart/form-data']) !!}
    <div class="d-flex justify-content-start align-items-center">
        <div>
            <h5 style="margin-block-end: 0px"><b>Seleziona</b></h5>
        </div>
        <div style="margin-left: 20px">Data check-in</div>
        <div style="margin-left: 10px">{!! Form::date('data_checkin', $data_checkin, ['class' => 'form-control']) !!}</div>
        <div style="margin-left: 10px">Data check-out</div>
        <div style="margin-left: 10px">{!! Form::date('data_checkout', $data_checkout, ['class' => 'form-control']) !!}
        </div>
        <div style="margin-left: 10px">Posti letto</div>
        <div style="margin-left: 10px">{!! Form::number('num_persone', $num_persone, ['class' => 'form-control']) !!}</div>
        <div style="margin-left: 20px">{{ Form::submit('Conferma', ['class' => 'btn btn-primary']) }}</div>
    </div>
    {!! Form::close() !!}
    <script>
        $('[name="id"]').change(function() {
            var optionSelected = $("option:selected", this);
            optionValue = this.value;
        });

    </script>
    <hr>
    @if (count($camere) > 0)
    <div class="row">
        @foreach ($camere as $camera)
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="vendor/adminlte/dist/img/bb.png"
                                alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">Camera {{ $camera->numero }}</h3>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Piano</b> <a class="float-right">{{ $camera->piano }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Numero letti</b> <a class="float-right">{{ $camera->numero_letti }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Costo a notte</b> <a class="float-right">{{ $camera->costo_a_notte }}</a>
                            </li>
                        </ul>
                        <a href="/camere/{{ $camera->numero }}" class="btn btn-primary btn-block"><b>Caratteristiche</b></a>
                        <a href="#" class="btn btn-success btn-block"><b>Prenota</b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        @endforeach
    </div>
    @else
        <p>Nessuna camera disponibile</p>
    @endif

@endsection
