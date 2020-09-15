@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/home" class="btn btn-outline-secondary">Indietro</a>
    <br>
    <br>
    <a href="/camere/create" class="btn btn-primary float-right">Aggiungi una nuova camera</a>
    <h1>Elenco camere</h1>
    <br>
    @if (count($camere) > 0)
        <div class="card">
            <div class="card-body">
                <table id="" class="display table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Numero</th>
                            <th>Piano</th>
                            <th>Posti letto</th>
                            <th>Costo a notte</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($camere as $camera)
                            <tr>
                                <td width=20%>
                                    {{ $camera->numero }}
                                </td>
                                <td width=20%>
                                    {{ $camera->piano }}
                                </td>
                                <td width=20%>
                                    {{ $camera->numero_letti }}
                                </td>
                                <td width=20%>
                                    {{ $camera->costo_a_notte }} €
                                </td>
                                <td width=20%>
                                    <div class="d-flex justify-content-around">
                                        <a button href="/camere/{{ $camera->numero }}"
                                            data-toggle="tooltip" data-placement="top" title="Visualizza"
                                            class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></button></a>
                                        <a button href="/camere/{{ $camera->numero }}/edit"
                                            data-toggle="tooltip" data-placement="top" title="Modifica"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>
                                        {!! Form::open(['action' => ['CameraController@destroy',
                                        $camera->numero], 'method' => 'POST']) !!}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::button('<i class="fa fa-trash"></i>', [
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger btn-sm',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'title' => 'Elimina',
                                                'onclick' => "return confirm('Confermi di voler eliminare questa camera? $camera->numero')",
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
        <p>Nessuna camera inserita</p>
    @endif

@endsection
