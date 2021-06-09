@extends('layouts.app')

@section('thousand_sunny_content')
<div class="col-12">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Modifica un'attività</h3>
        </div>
        <div class="card-body">
            <form id="formModificaAttivita">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="ditta_esterna_id" class="control-label">Ditta esterna</label>*
                        {{{Form::select('ditta_esterna_id', $ditte_esterne, $attivita->ditta_esterna_id, [ 'class' => 'form-control', 'placeholder' => 'Seleziona una ditta esterna', 'required' ])}}}
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="data" class="control-label">Data</label>*
                        <input type="date" class="form-control" name="data" id="data" placeholder="Data" value="{{$attivita->data}}" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="ora" class="control-label">Ora</label>*
                        <input type="time" class="form-control" name="ora" id="ora" placeholder="Ora" value="{{$attivita->ora}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="destinazione" class="control-label">Luogo di destinazione</label>*
                        <input type="text" class="form-control" name="destinazione" id="destinazione" placeholder="Luogo di destinazione" value="{{$attivita->destinazione}}" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="costo" class="control-label">Costo</label>*
                        <input type="number" min="1" class="form-control" name="costo" id="costo" placeholder="Costo" value="{{$attivita->costo}}" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <input type="hidden" value="{{$attivita->id}}" name="id" id="id">
                    <div class="col-6"><p class="pull-right">* campi obbligatori</p></div>
                    <div class="col-6"><button type="submit" id="modificaAttivita" class="btn btn-primary float-right">Conferma</button></div>
                </div>
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
            var formModificaAttivita = $('#formModificaAttivita');
            formModificaAttivita.submit(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/attivita/modifica-attivita',
                    data: formModificaAttivita.serialize(),
                    success: function (data) {
                        console.log(data);
                        if(data==true){
                            console.log('Submission was successful.');
                            alert("Attività modificata con successo!");
                            window.location.replace('/attivita/'+<?php echo $attivita->id ?>);
                        }else{
                            alert(data);
                        }
                    },
                    error: function (data) {
                        console.log('An error occurred.');
                        console.log(data);
                        alert("Impossibile modificare l'attività'!");
                    },
                });
            });
        });
    </script>
@stop
