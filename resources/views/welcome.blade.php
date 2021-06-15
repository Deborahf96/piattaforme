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
        @if(Auth::user()->id_level == 0)
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
        @else
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
                                    <h5 style="color: white"><strong>Le Tue Prenotazioni</strong></h5>
                                    <br>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-book">&nbsp;</i>
                                </div>
                                <a href="/prenotazioni_cliente" class="small-box-footer"><div style="color: white"> Visualizza <i class="fas fa-arrow-circle-right"></i></div></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h5><strong>Il Tuo Profilo</strong></h5>
                                    <br>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <a href="/cliente" class="small-box-footer">Visualizza <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h5 ><strong>Richiedi Assistenza</strong></h5>
                                    <br>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <a href="/moduli_assistenza/create" class="small-box-footer">Richiedi <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection