@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('js')

    <script> 
        $(document).ready(function() {
            var $table = $('table.display').DataTable( {
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Italian.json",
                    buttons: {
                        copyTitle: 'Contenuto tabella copiato',
                        copySuccess: {
                            _: '%d linee copiate',
                            1: '1 linea copiata'
                        }
                    }
                },
                "pageLength": 100,
                dom: '<"d-flex justify-content-between"lf>rt<"d-flex justify-content-between"Bip>',
                buttons: [
                    {
                        extend: 'copy',
                        text: 'Copia',
                        exportOptions: {
                            modifier: {
                                page: 'all'
                            }
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'Esporta in CSV',
                        exportOptions: {
                            modifier: {
                                page: 'all'
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Esporta in Excel',
                        exportOptions: {
                            modifier: {
                                page: 'all'
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Stampa',
                        exportOptions: {
                            modifier: {
                                page: 'all'
                            }
                        }
                    }
                ],
            });

        } );
    </script>

    <script> 
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

@stop

@section('content')
    @include('inc.messages')
    @yield('thousand_sunny_content')
@endsection