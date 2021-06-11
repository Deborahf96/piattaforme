@extends('layouts.app')

@section('thousand_sunny_content')
<div class="col-12">
    <div class="card card-primary card-outline">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Richiedi informazioni/Invia un reclamo</h3>
        </div>
        <div class="card-body">
            <form id="form">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="tipologia" class="control-label">Tipologia di assistenza</label>
                        {{{Form::select('tipologia', $assistenza_tipologia_enum, '', [ 'class' => 'form-control', 'placeholder' => 'Seleziona una tipologia di assistenza', 'required' ])}}}
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="oggetto" class="control-label">Oggetto</label>
                        <input type="text" class="form-control" name="oggetto" id="oggetto" placeholder="Oggetto" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="messaggio" class="control-label">Messaggio</label>
                        {{{Form::textarea('messaggio', '', [ 'class' => 'form-control', 'placeholder' => 'Inserisci un messaggio ...' , 'required'])}}}
                    </div>
                </div>
                <button type="submit" id="invia" class="btn btn-primary float-right">Invia richiesta</button>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
    <script>
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
         
        $(document).ready(function() {
            var form = $('#form');
            form.submit(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: 'invia',
                    data: form.serialize(),
                    success: function (data) {
                        console.log(data);
                        if(data){
                            console.log('Submission was successful.');
                            alert("Richiesta inviata con successo!");
                            window.location.replace('/moduli_assistenza');
                        }else{
                            alert(data);
                        }
                    },
                    error: function (data) {
                        console.log('An error occurred.');
                        console.log(data);
                        alert("Impossibile inviare la richiesta!");
                    },
                });
            });
        });
    </script>
@stop