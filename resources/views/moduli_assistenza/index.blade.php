@extends('layouts.app')

@section('thousand_sunny_content')
    <a href="/moduli_assistenza/create" class="btn btn-primary float-right">Invia una richiesta</a>
    <h1>Le tue richieste di assistenza</h1>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <table id="table" class="display table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Tipologia di assistenza</th>
                        <th>Oggetto</th>
                        <th>Data</th>
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
                    url: '/moduli_assistenza/table',
                    type: "POST"
                },
                columns: [
                    { data: "tipologia" , width: "30%" },
                    { data: "oggetto" , width: "30%"},
                    { data: "created_at" , width: "30%" , render : function (data, type, row, meta) {
                        return moment(data).format("DD-MM-YYYY HH:mm")
                    }},
                    { data: null , bSearchable: false , orderable: false , width: "10%" , render : function ( data, type, row, meta ) {
                        return '<div class="d-flex justify-content-around"><a button href="/moduli_assistenza/'+row.id+'" data-toggle="tooltip" data-placement="top" title="Visualizza" class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></button></a></div>';
                        },
                    },
                ]
            });
        });
    </script>
@stop

