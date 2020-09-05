@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/" class="btn btn-outline-secondary">Indietro</a>
    <br>
    <br>
    <a href="/attivita/create" class="btn btn-primary float-right">Aggiungi una nuova attività</a>
    <h1>Elenco attività</h1>
    <br>
    @if (count($attivita_totali) > 0)
        <div class="card">
            <div class="card-body">
                <table id="" class="display table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ditta esterna</th>
                            <th>Data</th>
                            <th>Ora</th>
                            <th>Destinazione</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attivita_totali as $attivita)
                            <tr>
                                <td width=5%>
                                    {{ $attivita->id }}
                                </td>
                                <td width=20%>
                                    {{ $attivita->ditta_esterna }}
                                </td>
                                <td width=20%>
                                    {{ $attivita->data }}
                                </td>
                                <td width=20%>
                                    {{ $attivita->ora }}
                                </td>
                                <td width=20%>
                                    {{ $attivita->destinazione }}
                                </td>
                                <td width=15%>
                                    <div class="d-flex justify-content-around">
                                        <a button href="/attivita/{{ $attivita->id }}"
                                            data-toggle="tooltip" data-placement="top" title="Visualizza"
                                            class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></button></a>
                                        <a button href="/attivita/{{ $attivita->id }}/edit"
                                            data-toggle="tooltip" data-placement="top" title="Modifica"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>
                                        {!! Form::open(['action' => ['AttivitaController@destroy',
                                        $attivita->id], 'method' => 'POST']) !!}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::button('<i class="fa fa-trash"></i>', [
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger btn-sm',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'title' => 'Elimina',
                                                'onclick' => "return confirm('Confermi di voler eliminare questa attività? $attivita->id')",
                                            ]) }}
                                        {!! Form::close() !!}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p>Nessuna attività inserita</p>
    @endif

@endsection
