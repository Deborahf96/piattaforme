@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/" class="btn btn-outline-secondary">Indietro</a>
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
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Indirizzo</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clienti as $cliente)
                            <tr>
                                <td width=20%>
                                    {{ $cliente->nome }}
                                </td>
                                <td width=20%>
                                    {{ $cliente->cognome }}
                                </td>
                                <td width=20%>
                                    {{ $cliente->indirizzo }}
                                </td>
                                <td width=20%>
                                    {{ $cliente->email }}
                                </td>
                                <td width=20%>
                                    <div class="d-flex justify-content-around">
                                        <a button href="/camere/{{ $cliente->email }}"
                                            data-toggle="tooltip" data-placement="top" title="Visualizza"
                                            class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></button></a>
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
