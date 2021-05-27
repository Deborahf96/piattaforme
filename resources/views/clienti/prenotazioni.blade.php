@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="{{URL::previous()}}" class="btn btn-outline-secondary">Indietro</a>
    <br>
    <br>
    <h2>Prenotazioni di: {{$cliente_name}}</h2>
    <br>
    @if (count($prenotazioni) > 0)
        <div class="card">
            <div class="card-body"> 
                <table id="" class="display table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Camera</th>
                            <th>Data check-in</th>
                            <th>Data check-out</th>
                            <th>Importo</th>
                            <th>Check pernottamento</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prenotazioni as $prenotazione)
                            <tr>
                                <td width=15%>
                                    {{ $prenotazione->camera->numero }}
                                </td>
                                <td width=15%>
                                    {{ $prenotazione->data_checkin }}
                                </td>
                                <td width=15%>
                                    {{ $prenotazione->data_checkout }}
                                </td>
                                <td width=15%>
                                    {{ $prenotazione->importo }} €
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
        <p>Nessuna prenotazione effettuata</p>
    @endif
@endsection
