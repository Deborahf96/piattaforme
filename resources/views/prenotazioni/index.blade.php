@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/" class="btn btn-outline-secondary">Indietro</a>
    <hr>

    <div class="d-flex justify-content-between" style="margin-left: 10px">
        <div class="row">
            {!! Form::open(['action' => ['PrenotazioneController@index'], 'method' => 'GET', 'enctype' =>
            'multipart/form-data']) !!}
            <div class="d-flex justify-content-start">
                <div class="d-flex justitfy-content-between align-items-center">
                    <div>
                        <h5 style="margin-block-end: 0px"><b>Seleziona data</b></h5>
                    </div>
                    <div style="margin-left: 20px">{!! Form::date('data_corrente', $data_corrente, ['class' => 'form-control']) !!}</div>
                </div>
                <div style="margin-left: 20px">{{ Form::submit('Conferma', ['class' => 'btn btn-primary']) }}</div>
                <a href="/prenotazioni" class="btn btn-primary" style="margin-left: 20px">Reset Filtri</a>
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
    <a href="/prenotazioni/prenota" class="btn btn-primary float-right">Aggiungi una nuova prenotazione</a>
    <h1>Elenco prenotazioni</h1>
    <br>
    @if (count($prenotazioni) > 0)
        <div class="card">
            <div class="card-body">
                <table id="" class="display table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Data check-in</th>
                            <th>Data check-out</th>
                            <th>Importo</th>
                            <th>Camera</th>
                            <th>Check pernottamento</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prenotazioni as $prenotazione)
                            <tr>
                                <td width=15%>
                                    {{ $prenotazione->data_checkin }}
                                </td>
                                <td width=15%>
                                    {{ $prenotazione->data_checkout }}
                                </td>
                                <td width=15%>
                                    {{ $prenotazione->importo }} €
                                </td>
                                <td width=15%>
                                    {{ $prenotazione->camera->numero }}
                                </td>
                                <td width=20%>
                                    {{ $prenotazione->check_pernottamento }}
                                </td>
                                <td width=20%>
                                    @php $stringa_onClick = $prenotazione->check_pernottamento == 'Confermato' ? 'annullare' : 'confermare' @endphp
                                    <div class="d-flex justify-content-around">
                                        <a button href="/prenotazioni/{{ $prenotazione->id }}" data-toggle="tooltip"
                                            data-placement="top" title="Visualizza" class="btn btn-success btn-sm"><i
                                                class="fa fa-search-plus"></i></button></a>
                                        
                                        {!! Form::open(['action' => ['PrenotazioneController@conferma_annulla_check',
                                        $prenotazione->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                        {{ Form::button('<i class="fa fa-check-circle"></i>', [
                                                'type' => 'submit',
                                                'class' => 'btn btn-primary btn-sm',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'title' => $prenotazione->check_pernottamento == 'Confermato' ? 'Annulla pernottamento' : 'Conferma pernottamento',
                                                'onclick' => "return confirm('Confermi di voler $stringa_onClick il pernottamento di questa prenotazione?')",
                                            ]) }}
                                        {!! Form::close() !!}

                                        {!! Form::open(['action' => ['PrenotazioneController@destroy', $prenotazione->id],
                                        'method' => 'POST']) !!}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::button('<i class="fa fa-trash"></i>', [
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger btn-sm',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'title' => 'Annulla',
                                                'onclick' => "return confirm('Confermi di voler annullare questa prenotazione?')",
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
        <p>Nessuna prenotazione inserita</p>
    @endif

@endsection
