@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/home" class="btn btn-outline-secondary">Indietro</a>
    <br>
    <br>
    <h1>Elenco clienti</h1>
    <br>
    @if (count($clienti) > 0)
        <div class="card">
            <div class="card-body">
                <table id="" class="display table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nome completo</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clienti as $cliente)
                            <tr>
                                <td width=50%>
                                    {{ $cliente->utente->name }}
                                </td>
                                <td width=30%>
                                    {{ $cliente->utente->email }}
                                </td>
                                <td width=20%>
                                    <div class="d-flex justify-content-around">
                                        <a button href="/clienti_latoDipendente/{{ $cliente->user_id }}"
                                            data-toggle="tooltip" data-placement="top" title="Visualizza"
                                            class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></button></a>
                                        <a button href="/clienti_latoDipendente/{{ $cliente->user_id }}/prenotazioni"
                                            data-toggle="tooltip" data-placement="top" title="Prenotazioni"
                                            class="btn btn-primary btn-sm"><i class="fa fa-bell"></i></button></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p>Nessun cliente registrato</p>
    @endif

@endsection
