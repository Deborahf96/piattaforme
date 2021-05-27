@extends('layouts.app')

@section('thousand_sunny_content')
    <h1>Elenco clienti</h1>
    <br>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <table id="tableClienti" class="display table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nome completo</th>
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
        $(document).ready(function() {
            var table = $('#tableClienti').DataTable({
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
                    url: '/clienti/table-clienti',
                    type: "POST"
                },
                columns: [
                    { data: "name" , width: "50%" },
                    { data: "email" , width: "30%"},
                    { data: null , bSearchable: false , orderable: false , width: "20%" , render : function ( data, type, row, meta ) {
                        var action = '<div class="d-flex justify-content-around">'+
                                    '<a button href="/clienti/'+row.user_id+'" data-toggle="tooltip" data-placement="top" title="Visualizza" class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></button></a>'+
                                    '<a button href="/clienti/'+row.user_id+'/prenotazioni" data-toggle="tooltip" data-placement="top" title="Prenotazioni" class="btn btn-primary btn-sm"><i class="fa fa-bell"></i></button></a></div>';
                        return action;
                        },
                    },
                ]
            });

            $('#tableClienti thead tr').clone(true).appendTo('#tableClienti thead');
            $('#tableClienti thead tr:eq(1) th').each(function(i) {
                var title = $(this).text();
                $(this).html('<input type="text" style="width:100%" placeholder="'+title+'" />');
                $('input', this).on('keyup change', function() {
                    if($('#tableClienti').DataTable().column(i).search() !== this.value) {
                        $('#tableClienti').DataTable()
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                });
            });
        });
    </script>
@stop
