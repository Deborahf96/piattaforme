@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/prenotazioni/prenota" class="btn btn-primary float-right">Aggiungi una nuova prenotazione</a>
    <h1>Elenco prenotazioni</h1>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <table id="table" class="display table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Data check-in</th>
                        <th>Data check-out</th>
                        <th>Camera</th>
                        <th>Cliente</th>
                        <th>Importo</th>
                        <th>Check pernottamento</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        function elimina(id) {
            if(confirm('Sei sicuro di voler annullare questa prenotazione?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/prenotazioni/elimina',
                    data: { 'id': id },
                    success: function(data) {
                        console.log(data);
                        if(data) {
                            alert('Prenotazione annullata con successo!');
                            $('#table').DataTable().ajax.reload();
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        alert('Errore! Non è possibile annullare la prenotazione!');
                    },
                });
            }
        }

        function check(id, check_pernottamento) {
            var azione = (check_pernottamento == 'Confermato') ? 'annullare' : 'confermare';
            if(confirm('Sei sicuro di voler '+azione+' il pernottamento di questa prenotazione?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/prenotazioni/check',
                    data: { 'id': id },
                    success: function(data) {
                        console.log(data);
                        if(data) {
                            alert('Prenotazione aggiornata con successo!');
                            $('#table').DataTable().ajax.reload();
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        alert('Errore! Non è possibile aggiornare la prenotazione!');
                    },
                });
            }
        }

        $(document).ready(function() {
            var table = $('#table').DataTable({
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
                    url: '/prenotazioni/table-prenotazioni',
                    type: "POST"
                },
                columns: [
                    { data: "data_checkin" , width: "15%" },
                    { data: "data_checkout" , width: "15%"},
                    { data: 'numero' , width: "10%" },
                    { data: 'name' , width: "15%" },
                    { data: "importo" , width: "10%" , render : function ( data, type, row, meta ) {
                        return data += ' €';
                    }},
                    { data: 'check_pernottamento' , width: "20%" },
                    { data: null , bSearchable: false , orderable: false , width: "15%" , render : function ( data, type, row, meta ) {
                        var title = (row.check_pernottamento == 'Confermato') ? 'Annulla pernottamento' : 'Conferma pernottamento';
                        return '<div class="d-flex justify-content-around">'+
                                '<a button href="/prenotazioni/'+row.id+'" data-toggle="tooltip" data-placement="top" title="Visualizza" class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></button></a>'+
                                '<button onclick="check(\''+row.id+'\',\''+row.check_pernottamento+'\')" data-toggle="tooltip" data-placement="top" title="'+title+'" class="btn btn-warning btn-sm"><i class="fa fa-check"></i></button>'+
                                '<button onclick="elimina(\''+row.id+'\')" data-toggle="tooltip" data-placement="top" title="Annulla" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div>';
                        },
                    },
                ]
            });

            $('#table thead tr').clone(true).appendTo('#table thead');
            $('#table thead tr:eq(1) th').each(function(i) {
                var title = $(this).text();
                $(this).html('<input type="text" style="width:100%" placeholder="'+title+'" />');
                $('input', this).on('keyup change', function() {
                    if($('#table').DataTable().column(i).search() !== this.value) {
                        $('#table').DataTable()
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                });
            });
        });
    </script>
@stop