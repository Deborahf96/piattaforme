@extends('layouts.app')

@section('thousand_sunny_content')
<a href="/ditte_esterne" class="btn btn-outline-secondary">Torna a ditte</a>
<hr>
<div class="col-md-12 d-flex align-items-stretch">
    <div class="card card-primary card-outline" style="width: 100%">
        <div class="card-header">
            <h5 class="card-title m-0"><b>Ditta Esterna</b></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"><b>Partita IVA</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $ditta_esterna->partita_iva }}</div>
                <div class="col-md-2"><b>Nome</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $ditta_esterna->nome }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Indirizzo</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $ditta_esterna->indirizzo }}</div>
                <div class="col-md-2"><b>Telefono</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $ditta_esterna->telefono }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Email</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $ditta_esterna->email }}</div>
                <div class="col-md-2"><b>IBAN</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $ditta_esterna->iban }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Descrizione</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $ditta_esterna->descrizione }}</div>
                <div class="col-md-2"><b>Tipo contratto</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $ditta_esterna->tipo_contratto }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Paga</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $ditta_esterna->paga }}</div>
                <div class="col-md-2"><b>Data inizio</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $ditta_esterna->data_inizio }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Data fine</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $ditta_esterna->data_fine }}</div>
            </div>
        </div>
    </div>
</div>

<a href="/ditte_esterne/{{$ditta_esterna->partita_iva}}/edit" class="btn btn-primary">Modifica</a>
{!! Form::open(['action' => ['DittaEsternaController@destroy', $ditta_esterna->partita_iva], 'method' => 'POST', 'class' =>
'float-right']) !!}
{{ Form::hidden('_method', 'DELETE') }}
{{ Form::submit('Elimina', [ 'class' => 'btn btn-danger', 'onclick' => "return confirm('Confermi di voler eliminare questa ditta? $ditta_esterna->nome ')"] )  }}
{!! Form::close() !!}
<hr>

@endsection