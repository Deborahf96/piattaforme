@extends('layouts.app')

@section('thousand_sunny_content')
<div class="col-12">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Aggiungi una nuova ditta</h3>
        </div>
        <div class="card-body">
            <form id="formAggiungiDitta">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="partita_iva" class="control-label">Partita IVA</label>*
                        <input type="text" minlength="11" maxlength="11" pattern="[0-9]*" class="form-control" name="partita_iva" id="partita_iva" placeholder="Partita IVA" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="nome" class="control-label">Nome</label>*
                        <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="indirizzo" class="control-label">Indirizzo</label>*
                        <input type="text" class="form-control" name="indirizzo" id="indirizzo" placeholder="Indirizzo" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="telefono" class="control-label">Telefono</label>*
                        <input type="tel" maxlength="10" pattern="[0-9]*" class="form-control" name="telefono" id="telefono" placeholder="Telefono" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="email" class="control-label">Email</label>*
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="iban" class="control-label">IBAN</label>*
                        <input type="text" minlength="27" maxlength="27" class="form-control" name="iban" id="iban" placeholder="IBAN" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="categoria" class="control-label">Categoria</label>*
                        {{{Form::select('categoria', $ditta_esterna_categoria_enum, '', [ 'class' => 'form-control', 'placeholder' => 'Seleziona una categoria', 'required' ])}}}
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="descrizione" class="control-label">Descrizione</label>
                        <input type="text" class="form-control" name="descrizione" id="descrizione" placeholder="Descrizione">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="paga" class="control-label">Stipendio</label>*
                        <input type="text" class="form-control" name="paga" id="paga" placeholder="Stipendio" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="tipo_contratto" class="control-label">Tipo contratto</label>*
                        {{{Form::select('tipo_contratto', $ditta_esterna_tipo_contratto_enum, '', [ 'class' => 'form-control', 'placeholder' => 'Seleziona un tipo di contratto', 'required' ])}}}
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="data_inizio" class="control-label">Data inizio</label>*
                        <input type="date" class="form-control" name="data_inizio" id="data_inizio" placeholder="Data inizio" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="data_fine" class="control-label">Data fine</label>
                        <input type="date" class="form-control" name="data_fine" id="data_fine" placeholder="Data fine">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6"><p class="pull-right">* campi obbligatori</p></div>
                    <div class="col-6"><button type="submit" id="aggiungiDitta" class="btn btn-primary float-right">Aggiungi</button></div>
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
            var formAggiungiDitta = $('#formAggiungiDitta');
            formAggiungiDitta.submit(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: 'aggiungi-ditta',
                    data: formAggiungiDitta.serialize(),
                    success: function (data) {
                        console.log(data);
                        if(data==true){
                            console.log('Submission was successful.');
                            alert("Ditta inserita con successo!");
                            window.location.replace('/ditte_esterne');
                        }else{
                            alert(data);
                        }
                    },
                    error: function (data) {
                        console.log('An error occurred.');
                        console.log(data);
                        alert("Impossibile inserire la ditta!");
                    },
                });
            });
        });
    </script>
@stop
