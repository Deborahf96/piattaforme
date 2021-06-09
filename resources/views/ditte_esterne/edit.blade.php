@extends('layouts.app')

@section('thousand_sunny_content')
<div class="col-12">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Modifica una ditta</h3>
        </div>
        <div class="card-body">
            <form id="formModificaDitta">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="partita_iva" class="control-label">Partita IVA</label>*
                        <input type="text" minlength="11" maxlength="11" pattern="[0-9]*" class="form-control" name="partita_iva" id="partita_iva" placeholder="Partita IVA" value="{{$ditta_esterna->partita_iva}}" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="nome" class="control-label">Nome</label>*
                        <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" value="{{$ditta_esterna->nome}}" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="indirizzo" class="control-label">Indirizzo</label>*
                        <input type="text" class="form-control" name="indirizzo" id="indirizzo" placeholder="Indirizzo" value="{{$ditta_esterna->indirizzo}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="telefono" class="control-label">Telefono</label>*
                        <input type="tel" maxlength="10" pattern="[0-9]*" class="form-control" name="telefono" id="telefono" placeholder="Telefono" value="{{$ditta_esterna->telefono}}" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="email" class="control-label">Email</label>*
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{$ditta_esterna->email}}" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="iban" class="control-label">IBAN</label>*
                        <input type="text" minlength="27" maxlength="27" class="form-control" name="iban" id="iban" placeholder="IBAN" value="{{$ditta_esterna->iban}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="categoria" class="control-label">Categoria</label>*
                        {{{Form::select('categoria', $ditta_esterna_categoria_enum, $ditta_esterna->categoria, [ 'class' => 'form-control', 'placeholder' => 'Seleziona una categoria', 'required' ])}}}
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="descrizione" class="control-label">Descrizione</label>
                        <input type="text" class="form-control" name="descrizione" id="descrizione" placeholder="Descrizione" value="{{$ditta_esterna->descrizione}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="paga" class="control-label">Stipendio</label>*
                        <input type="text" class="form-control" name="paga" id="paga" placeholder="Stipendio" value="{{$ditta_esterna->paga}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="tipo_contratto" class="control-label">Tipo contratto</label>*
                        {{{Form::select('tipo_contratto', $ditta_esterna_tipo_contratto_enum, $ditta_esterna->tipo_contratto, [ 'class' => 'form-control', 'placeholder' => 'Seleziona un tipo di contratto', 'required' ])}}}
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="data_inizio" class="control-label">Data inizio</label>*
                        <input type="date" class="form-control" name="data_inizio" id="data_inizio" placeholder="Data inizio" value="{{$ditta_esterna->data_inizio}}" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="data_fine" class="control-label">Data fine</label>
                        <input type="date" class="form-control" name="data_fine" id="data_fine" placeholder="Data fine" value="{{$ditta_esterna->data_fine}}">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <input type="hidden" value="{{$ditta_esterna->id}}" name="id" id="id">
                    <div class="col-6"><p class="pull-right">* campi obbligatori</p></div>
                    <div class="col-6"><button type="submit" id="modificaDitta" class="btn btn-primary float-right">Conferma</button></div>
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
            var formModificaDitta = $('#formModificaDitta');
            formModificaDitta.submit(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/ditte_esterne/modifica-ditta',
                    data: formModificaDitta.serialize(),
                    success: function (data) {
                        console.log(data);
                        if(data==true){
                            console.log('Submission was successful.');
                            alert("Ditta modificata con successo!");
                            window.location.replace('/ditte_esterne/'+<?php echo $ditta_esterna->partita_iva ?>);
                        }else{
                            alert(data);
                        }
                    },
                    error: function (data) {
                        console.log('An error occurred.');
                        console.log(data);
                        alert("Impossibile modificare la ditta!");
                    },
                });
            });
        });
    </script>
@stop
