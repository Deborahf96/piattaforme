@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/attivita/create" class="btn btn-primary float-right">Aggiungi una nuova attività</a>
    <h1>Elenco attività</h1>
    <br>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <table id="tableAttivita" class="display table table-striped table-bordered">
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
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        function elimina(id, tipologia, destinazione, data, ora) {
            if(confirm('Confermi di voler eliminare la seguente attività:\n'+tipologia+' ('+destinazione+') - '+data+' '+ora+' ?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/attivita/elimina',
                    data: { 'id': id },
                    success: function(data) {
                        console.log(data);
                        if(data) {
                            alert('Attività eliminata con successo!');
                            $('#tableAttivita').DataTable().ajax.reload();
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        alert("Errore! Non è possibile eliminare l'attività!");
                    },
                });
            }
        }

        $(document).ready(function() {
            var table = $('#tableAttivita').DataTable({
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
                    url: '/attivita/table-attivita',
                    type: "POST"
                },
                columns: [
                    { data: "nome" , width: "20%" },
                    { data: "tipologia" , width: "15%"},
                    { data: "data" , width: "10%" },
                    { data: 'ora' , width: "10%" },
                    { data: "destinazione" , width: "20%" },
                    { data: 'costo' , width: "10%" , render : function ( data, type, row, meta ) {
                        return data += ' €';
                    }},
                    { data: null , bSearchable: false , orderable: false , width: "15%" , render : function ( data, type, row, meta ) {
                        var action = '<div class="d-flex justify-content-around">'+
                                    '<a button href="/attivita/'+row.id+'" data-toggle="tooltip" data-placement="top" title="Visualizza" class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></button></a>'+
                                    '<a button href="/attivita/'+row.id+'/edit" data-toggle="tooltip" data-placement="top" title="Modifica" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>'+
                                    '<button onclick="elimina(\''+row.id+'\',\''+row.tipologia+'\',\''+row.destinazione+'\',\''+row.data+'\',\''+row.ora+'\')" data-toggle="tooltip" data-placement="top" title="Elimina" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div>';
                        return action;
                        },
                    },
                ]
            });

            $('#tableAttivita thead tr').clone(true).appendTo('#tableAttivita thead');
            $('#tableAttivita thead tr:eq(1) th').each(function(i) {
                var title = $(this).text();
                $(this).html('<input type="text" style="width:100%" placeholder="'+title+'" />');
                $('input', this).on('keyup change', function() {
                    if($('#tableAttivita').DataTable().column(i).search() !== this.value) {
                        $('#tableAttivita').DataTable()
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                });
            });
        });
    </script>
@stop