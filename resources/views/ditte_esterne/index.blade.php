@extends('layouts.app')

@section('thousand_sunny_content')
<a href="/" class="btn btn-outline-secondary">Indietro</a>
<br>
<br>
<a href="/ditte_esterne/create" class="btn btn-primary float-right">Aggiungi una nuova ditta</a>
<h1>Elenco ditte esterne</h1>
<br>
@if (count ($ditte_esterne) > 0)
<div class="card">
    <div class="card-body">
        <table id="" class="display table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Partita IVA</th>
                    <th>Nome</th>
                    <th>Indirizzo</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ditte_esterne as $ditta_esterna)
                <tr>
                    <td width=20%>
                        {{ $ditta_esterna->partita_iva }}
                    </td>
                    <td width=20%>
                        {{ $ditta_esterna->nome }}
                    </td>
                    <td width=20%>
                        {{ $ditta_esterna->indirizzo }}
                    </td>
                    <td width=20%>
                        {{ $ditta_esterna->email }}
                    </td>
                    
                    <td width=20%>
                        <div class="d-flex justify-content-around">
                            <a button href="/ditte_esterne/{{$ditta_esterna->partita_iva}}" data-toggle="tooltip" data-placement="top" title="Visualizza" class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></button></a>
                            <a button href="/ditte_esterne/{{$ditta_esterna->partita_iva}}/edit" data-toggle="tooltip" data-placement="top" title="Modifica" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>
                            {!! Form::open(['action' => ['DittaEsternaController@destroy', $ditta_esterna->partita_iva], 'method' =>
                            'POST']) !!}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::button('<i class="fa fa-trash"></i>', [
                                        'type' => 'submit', 
                                        'class' => 'btn btn-danger btn-sm', 
                                        'data-toggle' => 'tooltip', 
                                        'data-placement' => 'top', 
                                        'title' => "Elimina", 
                                        'onclick' => "return confirm('Confermi di voler eliminare questa ditta? $ditta_esterna->nome')"] )  }}
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
<p>Nessuna ditta inserita</p>
@endif

@endsection