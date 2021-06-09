@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/dipendenti/create" class="btn btn-primary float-right">Aggiungi un nuovo dipendente</a>
    <h1>Elenco dipendenti</h1>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <table id="tableDipendenti" class="display table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nome completo</th>
                        <th>Ruolo</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        function elimina(user_id, nome) {
            if(confirm('Sei sicuro di voler eliminare il dipendente "'+nome+'"?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/dipendenti/elimina',
                    data: { 'user_id': user_id },
                    success: function(data) {
                        console.log(data);
                        if(data) {
                            alert('Dipendente eliminato con successo!');
                            $('#tableDipendenti').DataTable().ajax.reload();
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        alert('Errore! Non è possibile eliminare il dipendente!');
                    },
                });
            }
        }

        $(document).ready(function() {
            var table = $('#tableDipendenti').DataTable({
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
                    url: '/dipendenti/table-dipendenti',
                    type: "POST"
                },
                columns: [
                    { data: "name" , width: "30%" },
                    { data: "ruolo" , width: "20%"},
                    { data: "email" , width: "30%" },
                    { data: null , bSearchable: false , orderable: false , width: "20%" , render : function ( data, type, row, meta ) {
                        var action = '<div class="d-flex justify-content-around">'+
                                    '<a button href="/dipendenti/'+row.user_id+'" data-toggle="tooltip" data-placement="top" title="Visualizza" class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></button></a>'+
                                    '<a button href="/dipendenti/'+row.user_id+'/edit" data-toggle="tooltip" data-placement="top" title="Modifica" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>'+
                                    '<button onclick="elimina(\''+row.user_id+'\',\''+row.name+'\')" data-toggle="tooltip" data-placement="top" title="Elimina" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div>';
                        return action;
                        },
                    },
                ]
            });
        });
    </script>
@stop