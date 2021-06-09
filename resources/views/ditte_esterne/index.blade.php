@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/ditte_esterne/create" class="btn btn-primary float-right">Aggiungi una nuova ditta</a>
    <h1>Elenco ditte esterne</h1>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <table id="tableDitte" class="display table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Indirizzo</th>
                        <th>Email</th>
                        <th>Categoria</th>
                        <th>Descrizione</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        function elimina(id, nome) {
            if(confirm('Sei sicuro di voler eliminare la ditta "'+nome+'"?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/ditte_esterne/elimina',
                    data: { 'id': id },
                    success: function(data) {
                        console.log(data);
                        if(data) {
                            alert('Ditta eliminata con successo!');
                            $('#tableDitte').DataTable().ajax.reload();
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        alert('Errore! Non è possibile eliminare la ditta!');
                    },
                });
            }
        }

        $(document).ready(function() {
            var table = $('#tableDitte').DataTable({
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
                    url: '/ditte_esterne/table-ditte',
                    type: "POST"
                },
                columns: [
                    { data: "nome" , width: "20%" },
                    { data: "indirizzo" , width: "20%"},
                    { data: "email" , width: "15%" },
                    { data: 'categoria' , width: "15%" },
                    { data: "descrizione" , width: "15%" , render : function ( data, type, row, meta ) {
                        return data==null ? '-' : data;
                        }
                    },
                    { data: null , bSearchable: false , orderable: false , width: "15%" , render : function ( data, type, row, meta ) {
                        var action = '<div class="d-flex justify-content-around">'+
                                    '<a button href="/ditte_esterne/'+row.partita_iva+'" data-toggle="tooltip" data-placement="top" title="Visualizza" class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></button></a>'+
                                    '<a button href="/ditte_esterne/'+row.partita_iva+'/edit" data-toggle="tooltip" data-placement="top" title="Modifica" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>'+
                                    '<button onclick="elimina(\''+row.id+'\',\''+row.nome+'\')" data-toggle="tooltip" data-placement="top" title="Elimina" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div>';
                        return action;
                        },
                    },
                ]
            });
        });
    </script>
@stop