@extends('layouts.app')

@php $utente=Auth::user()->name
@endphp

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">Benvenuto!</div>
                    <div class="card-body">Hai eseguito l'accesso come {{$utente}}</div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-12">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h5><strong>Nuova Prenotazione</strong></h5>
                                <br>
                            </div>
                            <div class="icon">
                                <i class="fas fa-bed"></i>
                            </div>
                            <a href="/prenotazioni/prenota" class="small-box-footer">Prenota <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h5 style="color: white"><strong>Nuovo Dipendente</strong></h5>
                                <br>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <a href="/dipendenti/create" class="small-box-footer"><div style="color: white"> Aggiungi <i class="fas fa-arrow-circle-right"></i></div></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-12">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h5 ><strong>Nuova Ditta Esterna</strong></h5>
                                <br>
                            </div>
                            <div class="icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <a href="/ditte_esterne/create" class="small-box-footer">Aggiungi <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h5><strong>Nuova Attività</strong></h5>
                                <br>
                            </div>
                            <div class="icon">
                                <i class="fas fa-briefcase">&nbsp;</i>
                            </div>
                            <a href="/attivita/create" class="small-box-footer">Aggiungi <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection