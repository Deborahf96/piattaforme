@extends('layouts.app')

@section('thousand_sunny_content')
<a href="/camere" class="btn btn-outline-secondary">Torna a camere</a>
<hr>
<div class="col-md-12 d-flex align-items-stretch">
    <div class="card card-primary card-outline" style="width: 100%">
        <div class="card-header">
            <h5 class="card-title m-0"><b>Cameraa</b></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"><b>Numero</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $camera->numero }}</div>
                <div class="col-md-2"><b>Disponibilità</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $camera->disponibilità }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Numero letti</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $camera->numero_letti }}</div>
                <div class="col-md-2"><b>Piano</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $camera->piano }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Descrizione</b></div>
                <div class="col-md-8 col-md-offset-1">{{ $camera->descrizione }}</div>
            </div>
        </div>
    </div>
</div>

<a href="/camere/{{$camera->numero}}/edit" class="btn btn-primary">Modifica</a>
{!! Form::open(['action' => ['CameraController@destroy', $camera->numero], 'method' => 'POST', 'class' =>
'float-right']) !!}
{{ Form::hidden('_method', 'DELETE') }}
{{ Form::submit('Elimina', [ 'class' => 'btn btn-danger', 'onclick' => "return confirm('Confermi di voler eliminare questa camera? $camera->numero ')"] )  }}
{!! Form::close() !!}
<hr>

@endsection