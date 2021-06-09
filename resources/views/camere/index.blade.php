@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/camere/create" class="btn btn-primary float-right">Aggiungi una nuova camera</a>
    <h1>Elenco camere</h1>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <table id="tableCamere" class="display table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Piano</th>
                        <th>Posti letto</th>
                        <th>Costo a notte</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        function elimina(id, numero) {
            if(confirm('Confermi di voler eliminare la camera N°'+numero+'?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/camere/elimina',
                    data: { 'id': id },
                    success: function(data) {
                        console.log(data);
                        if(data) {
                            alert('Camera eliminata con successo!');
                            $('#tableCamere').DataTable().ajax.reload();
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        alert('Errore! Non è possibile eliminare la camera!');
                    },
                });
            }
        }

        $(document).ready(function() {
            var table = $('#tableCamere').DataTable({
                responsive: true,
                pageLength : 10,
                lengthMenu: [[10, 20, 30, 50], [10, 20, 30, 50]],
                language: {
                    lengthMenu: "Visualizza _MENU_ elementi per pagina",
                    zeroRecords: "Nessun dato da visualizzare",
                    infoFiltered: "<b>(filtrati su _MAX_ totali)</b>",
                    info: "Pagina da _PAGE_ a _PAGES_ <b>( _TOTAL_ elementi totali )</b>",
                    infoEmpty: "Nessun dato presente",
                    search: "Cerca:",
                    paginate: {
                        first: "Primo",
                        last: "Ultimo",
                        next: "Successivo",
                        previous: "Precedente",
                    },
                    loadingRecords: "&nbsp;",
                    processing: "Caricamento..."
                },
                processing: true,
                serverSide: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/camere/table-camere',
                    type: "POST"
                },
                columns: [
                    { data: "numero" , width: "20%" },
                    { data: "piano" , width: "20%"},
                    { data: "numero_letti" , width: "20%" },
                    { data: 'costo_a_notte' , width: "20%" , render : function ( data, type, row, meta ) {
                        return data += ' €';
                        }
                    },
                    { data: null , bSearchable: false , orderable: false , width: "20%" , render : function ( data, type, row, meta ) {
                        var action = '<div class="d-flex justify-content-around">'+
                                    '<a button href="/camere/'+row.id+'" data-toggle="tooltip" data-placement="top" title="Visualizza" class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></button></a>'+
                                    '<a button href="/camere/'+row.id+'/edit" data-toggle="tooltip" data-placement="top" title="Modifica" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>'+
                                    '<button onclick="elimina(\''+row.id+'\',\''+row.numero+'\')" data-toggle="tooltip" data-placement="top" title="Elimina" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div>';
                        return action;
                        },
                    },
                ]
            });
        });
    </script>
@stop
