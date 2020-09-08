@extends('layouts.app')

<title> Thousand Sunny B&B | Dipendenti </title>

@section('thousand_sunny_content')
    <a href="/" class="btn btn-outline-secondary">Indietro</a>
    <hr>
    <div class="d-flex justify-content-between" style="margin-left: 10px">
        <div class="row">
            {!! Form::open(['action' => ['DipendenteController@index'], 'method' => 'GET', 'enctype' =>
            'multipart/form-data']) !!}
            <div class="d-flex justify-content-start">
                <div class="d-flex justitfy-content-between align-items-center">
                    <div>
                        <h5 style="margin-block-end: 0px"><b>Seleziona ruolo</b></h5>
                    </div>
                    <div style="margin-left: 20px">{!! Form::select('ruolo', $dipendente_ruolo_enum,
                        $ruolo_corrente, ['class' => 'form-control', 'placeholder' => 'Tutti']) !!}</div>
                </div>
                <div style="margin-left: 20px">{{ Form::submit('Conferma', ['class' => 'btn btn-primary']) }}</div>
                <a href="/dipendenti" class="btn btn-primary" style="margin-left: 20px">Reset Filtri</a>
            </div>
            {!! Form::close() !!}
        </div>
        <script>
            $('[name="id"]').change(function() {
                var optionSelected = $("option:selected", this);
                optionValue = this.value;
            });
        </script>
    </div>
    <hr>
    <a href="/dipendenti/create" class="btn btn-primary float-right">Aggiungi un nuovo dipendente</a>
    <h1>Elenco dipendenti</h1>
    <br>
    @if (count($dipendenti) > 0)
        <div class="card">
            <div class="card-body">
                <table id="" class="display table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Ruolo</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dipendenti as $dipendente)
                            <tr>
                                <td width=20%>
                                    {{ $dipendente->utente->name }}
                                </td>
                                <td width=20%>
                                    {{ $dipendente->utente->cognome }}
                                </td>
                                <td width=20%>
                                    {{ $dipendente->ruolo }}
                                </td>
                                <td width=20%>
                                    {{ $dipendente->utente->email }}
                                </td>
                                <td width=20%>
                                    <div class="d-flex justify-content-around">
                                        <a button href="/dipendenti/{{ $dipendente->user_id }}"
                                            data-toggle="tooltip" data-placement="top" title="Visualizza"
                                            class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></button></a>
                                        <a button href="/dipendenti/{{ $dipendente->user_id }}/edit"
                                            data-toggle="tooltip" data-placement="top" title="Modifica"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>
                                        @php $username = $dipendente->utente->name.' '.$dipendente->utente->cognome @endphp
                                        {!! Form::open(['action' => ['DipendenteController@destroy',
                                        $dipendente->user_id], 'method' => 'POST']) !!}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::button('<i class="fa fa-trash"></i>', [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'data-toggle' => 'tooltip',
                                    'data-placement' => 'top',
                                    'title' => 'Elimina',
                                    'onclick' => "return confirm('Confermi di voler eliminare questo dipendente? $username')",
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
        <p>Nessun dipendente inserito</p>
    @endif

@endsection
