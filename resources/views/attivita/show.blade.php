@extends('layouts.app')

<title> Thousand Sunny B&B | Attività </title>

@section('thousand_sunny_content')
    <a href="/attivita" class="btn btn-outline-secondary">Torna a attività</a>
    <hr>
    <div class="col-md-12 d-flex align-items-stretch">
        <div class="card card-primary card-outline" style="width: 100%">
            <div class="card-header">
                <h5 class="card-title m-0"><b>Attività</b></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2"><b>Ditta esterna</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $attivita->ditta_esterna->nome }}</div>
                    <div class="col-md-2"><b>Numero massimo di partecipanti</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $attivita->max_persone }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Data</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ \Carbon\Carbon::parse($attivita->data)->format('d/m/Y') }}
                    </div>
                    <div class="col-md-2"><b>Luogo di destinazione</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $attivita->destinazione }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><b>Ora</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ \Carbon\Carbon::parse($attivita->ora)->format('H:i') }}
                    </div>
                    <div class="col-md-2"><b>Tipologia</b></div>
                    <div class="col-md-3 col-md-offset-1">{{ $attivita->tipologia }}</div>
                </div>
            </div>
        </div>
    </div>
    
    @php $ditta = $attivita->ditta_esterna->partita_iva @endphp
    <a href="/attivita/{{ $attivita->id }}/edit" class="btn btn-primary">Modifica</a>
    <a href="/ditte_esterne/{{ $ditta }}"  class="btn btn-info">Visualizza ditta esterna</a>
    {!! Form::open(['action' => ['AttivitaController@destroy', $attivita->id], 'method' => 'POST', 'class' =>
    'float-right']) !!}
    {{ Form::hidden('_method', 'DELETE') }}
    {{ Form::submit('Elimina', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Confermi di voler eliminare questa attivita?')"]) }}
    {!! Form::close() !!}
    <hr>

@endsection
