@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="{{ URL::previous() }}" class="btn btn-outline-secondary">Indietro</a>
    <br>
    <br>
    <h1>Seleziona attività</h1>
    <br>
    {!! Form::open(['action' => ['PrenotazioneAttivitaController@conferma_attivita', $prenotazione_id], 'method' => 'GET', 'enctype' => 'multipart/form-data']) !!}
    @if (count($attivita) > 0)
        <div class="card">
            <div class="card-body">
                <table id="" class="display table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Ora</th>
                            <th>Destinazione</th>
                            <th>Tipologia</th>
                            <th>Costo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attivita as $singola_attivita)
                            <tr>
                                <td width=15%>
                                    {{ $singola_attivita->data }}
                                </td>
                                <td width=15%>
                                    {{ \Carbon\Carbon::parse($singola_attivita->ora)->format('H:i') }}
                                </td>
                                <td width=15%>
                                    {{ $singola_attivita->destinazione }}
                                </td>
                                <td width=15%>
                                    {{ $singola_attivita->tipologia }}
                                </td>
                                <td width=20%>
                                    {{ $singola_attivita->costo }} €
                                </td>
                                <td width=20%>
                                    <div class="d-flex justify-content-center">
                                        {{ Form::checkbox('attivita[]', $singola_attivita->id) }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p>Nessuna attività disponibile</p>
    @endif
    {{ Form::submit('Avanti', ['class' => 'btn btn-primary float-right', 'style' => 'margin-right:10px']) }}
    {!! Form::close() !!}

@endsection
