@extends('layouts.app')

@section('thousand_sunny_content')
<a href="/dipendenti" class="btn btn-outline-secondary" style="margin-left: 10px">Indietro</a>
<br>
<br>
<div class="col-12">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Aggiungi un nuovo dipendente</h3>
        </div>
        <div class="card-body">
            <form id="formAggiungiDipendente">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="nome" class="control-label">Nome completo</label>*
                        <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome completo" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="data_nascita" class="control-label">Data di nascita</label>
                        <input type="date" class="form-control" name="data_nascita" id="data_nascita" placeholder="Data di nascita">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="luogo_nascita" class="control-label">Luogo di nascita</label>
                        <input type="text" class="form-control" name="luogo_nascita" id="luogo_nascita" placeholder="Luogo di nascita">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="indirizzo" class="control-label">Indirizzo</label>
                        <input type="text" class="form-control" name="indirizzo" id="indirizzo" placeholder="Indirizzo">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="telefono" class="control-label">Telefono</label>
                        <input type="tel" maxlength="10" pattern="[0-9]*" class="form-control" name="telefono" id="telefono" placeholder="Telefono">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="email" class="control-label">Email</label>*
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="tipo_contratto" class="control-label">Tipo contratto</label>
                        {{{Form::select('tipo_contratto', $dipendente_tipo_contratto_enum, '', [ 'class' => 'form-control', 'placeholder' => 'Seleziona un tipo di contratto' ])}}}
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="ruolo" class="control-label">Ruolo</label>
                        {{{Form::select('ruolo', $dipendente_ruolo_enum, '', [ 'class' => 'form-control', 'placeholder' => 'Seleziona un ruolo' ])}}}
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="ore_settimanali" class="control-label">Ore settimanali</label>
                        <input type="number" min="1" class="form-control" name="ore_settimanali" id="ore_settimanali" placeholder="Ore settimanali">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="data_inizio" class="control-label">Data inizio</label>
                        <input type="date" class="form-control" name="data_inizio" id="data_inizio" placeholder="Data inizio">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="data_fine" class="control-label">Data fine</label>
                        <input type="date" class="form-control" name="data_fine" id="data_fine" placeholder="Data fine">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="stipendio" class="control-label">Stipendio</label>
                        <input type="text" class="form-control" name="stipendio" id="stipendio" placeholder="Stipendio">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="iban" class="control-label">IBAN</label>
                        <input type="text" minlength="27" maxlength="27" class="form-control" name="iban" id="iban" placeholder="IBAN">
                    </div>
                </div>
                <hr>
                <p class="pull-right">* campi obbligatori</p>
                <button type="submit" id="aggiungiDitta" class="btn btn-primary float-right">Aggiungi</button>
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
            var formAggiungiDipendente = $('#formAggiungiDipendente');
            formAggiungiDipendente.submit(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: 'aggiungi-dipendente',
                    data: formAggiungiDipendente.serialize(),
                    success: function (data) {
                        console.log(data);
                        if(data==true){
                            console.log('Submission was successful.');
                            alert("Dipendente inserito con successo!");
                            window.location.replace('/dipendenti');
                        }else{
                            alert(data);
                        }
                    },
                    error: function (data) {
                        console.log('An error occurred.');
                        console.log(data);
                        alert("Impossibile inserire il dipendente!");
                    },
                });
            });
        });
    </script>
@stop
