@extends('layouts.app')

@section('thousand_sunny_content')
<div class="col-12">
    <a href="/dipendenti" class="btn btn-outline-secondary" style="margin-left: 10px">Torna a dipendenti</a>
    <br>
    <br>
    <div class="card card-outline card-primary">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Modifica un dipendente</h3>
        </div>
        <div class="card-body">
            <form id="formModificaDipendente">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="nome" class="control-label">Nome completo</label>*
                        <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome completo" value="{{$dipendente->utente->name}}" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="data_nascita" class="control-label">Data di nascita</label>
                        <input type="date" class="form-control" name="data_nascita" id="data_nascita" placeholder="Data di nascita" value="{{$dipendente->utente->data_nascita}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="luogo_nascita" class="control-label">Luogo di nascita</label>
                        <input type="text" class="form-control" name="luogo_nascita" id="luogo_nascita" placeholder="Luogo di nascita" value="{{$dipendente->utente->luogo_nascita}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="indirizzo" class="control-label">Indirizzo</label>
                        <input type="text" class="form-control" name="indirizzo" id="indirizzo" placeholder="Indirizzo" value="{{$dipendente->utente->indirizzo}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="telefono" class="control-label">Telefono</label>
                        <input type="tel" maxlength="10" pattern="[0-9]*" class="form-control" name="telefono" id="telefono" placeholder="Telefono" value="{{$dipendente->utente->telefono}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="email" class="control-label">Email</label>*
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{$dipendente->utente->email}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="tipo_contratto" class="control-label">Tipo contratto</label>
                        {{{Form::select('tipo_contratto', $dipendente_tipo_contratto_enum, $dipendente->tipo_contratto, [ 'class' => 'form-control', 'placeholder' => 'Seleziona un tipo di contratto' ])}}}
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="ruolo" class="control-label">Ruolo</label>
                        {{{Form::select('ruolo', $dipendente_ruolo_enum, $dipendente->ruolo, [ 'class' => 'form-control', 'placeholder' => 'Seleziona un ruolo' ])}}}
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="ore_settimanali" class="control-label">Ore settimanali</label>
                        <input type="number" min="1" class="form-control" name="ore_settimanali" id="ore_settimanali" placeholder="Ore settimanali" value="{{$dipendente->ore_settimanali}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="data_inizio" class="control-label">Data inizio</label>
                        <input type="date" class="form-control" name="data_inizio" id="data_inizio" placeholder="Data inizio" value="{{$dipendente->data_inizio}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="data_fine" class="control-label">Data fine</label>
                        <input type="date" class="form-control" name="data_fine" id="data_fine" placeholder="Data fine" value="{{$dipendente->data_fine}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="stipendio" class="control-label">Stipendio</label>
                        <input type="text" class="form-control" name="stipendio" id="stipendio" placeholder="Stipendio" value="{{$dipendente->stipendio}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="iban" class="control-label">IBAN</label>
                        <input type="text" minlength="27" maxlength="27" class="form-control" name="iban" id="iban" placeholder="IBAN" value="{{$dipendente->iban}}">
                    </div>
                </div>
                <hr>
                <input type="hidden" value="{{$dipendente->user_id}}" name="user_id" id="user_id">
                <p class="pull-right">* campi obbligatori</p>
                <button type="submit" id="modificaDipendente" class="btn btn-primary float-right">Conferma</button>
            </div>
        </form>    
    </div>
</div>
@stop

@section('js')
    <script>
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
         
        $(document).ready(function() {
            var formModificaDipendente = $('#formModificaDipendente');
            formModificaDipendente.submit(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/dipendenti/modifica-dipendente',
                    data: formModificaDipendente.serialize(),
                    success: function (data) {
                        console.log(data);
                        if(data==true){
                            console.log('Submission was successful.');
                            alert("Dipendente modificato con successo!");
                            window.location.replace('/dipendenti/'+<?php echo $dipendente->user_id ?>);
                        }else{
                            alert(data);
                        }
                    },
                    error: function (data) {
                        console.log('An error occurred.');
                        console.log(data);
                        alert("Impossibile modificare il dipendente!");
                    },
                });
            });
        });
    </script>
@stop
