@extends('layouts.app')

@section('thousand_sunny_content')
<a href="/moduli_assistenza" class="btn btn-outline-secondary">Torna alle tue richieste</a>
<hr>
<div class="col-md-12 d-flex align-items-stretch">
    <div class="card card-primary card-outline" style="width: 100%">
        <div class="card-header">
            <h5 class="card-title m-0"><b>Richiesta di assistenza</b></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"><b>Tipologia di richiesta</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $assistenza->tipologia }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Oggetto</b></div>
                <div class="col-md-3 col-md-offset-1">{{ $assistenza->oggetto }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Data</b></div>
                <div class="col-md-3 col-md-offset-1">
                    {{ \Carbon\Carbon::parse($assistenza->created_at)->format('d/m/Y H:i') }}
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2"><b>Messaggio</b></div>
                <div class="col-md-8 col-md-offset-1">{{ $assistenza->messaggio }}</div>
            </div>
        </div>
    </div>
</div>


<hr>

@endsection