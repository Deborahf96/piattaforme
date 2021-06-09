@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/prenotazioni/prenota" class="btn btn-primary float-right">Effettua una nuova prenotazione</a>
    <h1>Storico prenotazioni</h1>
    <br>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <table id="table" class="display table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Data check-in</th>
                        <th>Data check-out</th>
                        <th>Importo</th>
                        <th>Camera</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script>
        function elimina(id) {
            if(confirm('Confermi di voler annullare questa prenotazione?')) {
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
                    url: '/prenotazioni_cliente/table-prenotazioni',
                    type: "POST"
                },
                columns: [
                    { data: "data_checkin" , width: "20%" },
                    { data: "data_checkout" , width: "20%"},
                    { data: "importo" , width: "20%" , render : function ( data, type, row, meta ) {
                        return data += ' €';
                    }},
                    { data: 'numero' , width: "20%" },
                    { data: null , bSearchable: false , orderable: false , width: "20%" , render : function ( data, type, row, meta ) {
                        var action = '<div class="d-flex justify-content-around">'+
                                    '<a button href="/prenotazioni_cliente/'+row.id+'" data-toggle="tooltip" data-placement="top" title="Visualizza" class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></a>';
                        if(moment(data.data_checkout,'YYYY/M/D').diff(moment(), 'days') >= 14)
                            action += '<button onclick="elimina(\''+row.id+'\')" data-toggle="tooltip" data-placement="top" title="Annulla" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div>';
                        else
                            action += '<a button data-toggle="tooltip" data-placement="top" title="Annulla" class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i></a></div>';
                        return action;
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
