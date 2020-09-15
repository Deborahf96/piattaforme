@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/home" class="btn btn-outline-secondary">Indietro</a>
    <hr>
    <div class="d-flex justify-content-between" style="margin-left: 10px">
        <div class="row">
            {!! Form::open(['action' => ['AttivitaController@index'], 'method' => 'GET', 'enctype' =>
            'multipart/form-data']) !!}
            <div class="d-flex justify-content-start">
                <div class="d-flex justitfy-content-between align-items-center">
                    <div>
                        <h5 style="margin-block-end: 0px"><b>Seleziona tipologia</b></h5>
                    </div>
                    <div style="margin-left: 20px">{!! Form::select('tipologia', $attivita_tipologia_enum,
                        $tipologia_corrente, ['class' => 'form-control', 'placeholder' => 'Tutte']) !!}</div>
                </div>
                <div style="margin-left: 20px">{{ Form::submit('Conferma', ['class' => 'btn btn-primary']) }}</div>
                <a href="/attivita" class="btn btn-primary" style="margin-left: 20px">Reset Filtri</a>
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
    <a href="/attivita/create" class="btn btn-primary float-right">Aggiungi una nuova attività</a>
    <h1>Elenco attività</h1>
    <br>
    @if (count($attivita) > 0)
        <div class="card">
            <div class="card-body">
                <table id="" class="display table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Ditta esterna</th>
                            <th>Tipologia</th>
                            <th>Data</th>
                            <th>Ora</th>
                            <th>Destinazione</th>
                            <th>Costo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attivita as $singola_attivita)
                            <tr>
                                <td width=20%>
                                    {{ $singola_attivita->ditta_esterna->nome }}
                                </td>
                                <td width=15%>
                                    {{ $singola_attivita->tipologia }}
                                </td>
                                <td width=15%>
                                    {{ $singola_attivita->data }}
                                </td>
                                <td width=10%>
                                    {{ \Carbon\Carbon::parse($singola_attivita->ora)->format('H:i') }}
                                </td>
                                <td width=15%>
                                    {{ $singola_attivita->destinazione }}
                                </td>
                                <td width=10%>
                                    {{ $singola_attivita->costo }} €
                                </td>
                                <td width=15%>
                                    <div class="d-flex justify-content-around">
                                        <a button href="/attivita/{{ $singola_attivita->id }}"
                                            data-toggle="tooltip" data-placement="top" title="Visualizza"
                                            class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></button></a>
                                        <a button href="/attivita/{{ $singola_attivita->id }}/edit"
                                            data-toggle="tooltip" data-placement="top" title="Modifica"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>
                                        {!! Form::open(['action' => ['AttivitaController@destroy',
                                        $singola_attivita->id], 'method' => 'POST']) !!}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::button('<i class="fa fa-trash"></i>', [
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger btn-sm',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'title' => 'Elimina',
                                                'onclick' => "return confirm('Confermi di voler eliminare questa attività?')",
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
