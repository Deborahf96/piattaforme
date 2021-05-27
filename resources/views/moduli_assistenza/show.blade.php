@extends('layouts.app')

@section('thousand_sunny_content')
<div class="col-12">
    <a href="/moduli_assistenza" class="btn btn-outline-secondary">Torna alle tue richieste</a>
    <br>
    <br>
    <div class="card card-primary card-outline">
        <div class="card-header d-flex p-0">
            <h5 class="card-title p-3">Richiesta di assistenza</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4"><b>Tipologia di richiesta</b></div>
                <div class="col-md-6 col-md-offset-2">{{ $assistenza->tipologia }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4"><b>Oggetto</b></div>
                <div class="col-md-6 col-md-offset-2">{{ $assistenza->oggetto }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4"><b>Data</b></div>
                <div class="col-md-6 col-md-offset-2">{{ \Carbon\Carbon::parse($assistenza->created_at)->format('d/m/Y H:i') }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4"><b>Messaggio</b></div>
                <div class="col-md-6 col-md-offset-2">{{ $assistenza->messaggio }}</div>
            </div>
        </div>
    </div>
</div>
@stop