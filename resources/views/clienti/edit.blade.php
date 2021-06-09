@extends('layouts.app')

@section('thousand_sunny_content')
<div class="col-12">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Modifica profilo</h3>
        </div>
        <div class="card-body">
            <form id="formModificaProfilo">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="nome" class="control-label">Nome completo</label>*
                        <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome completo" value="{{$cliente->utente->name}}" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="data_nascita" class="control-label">Data di nascita</label>
                        <input type="date" class="form-control" name="data_nascita" id="data_nascita" placeholder="Data di nascita" value="{{$cliente->utente->data_nascita}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="luogo_nascita" class="control-label">Luogo di nascita</label>
                        <input type="text" class="form-control" name="luogo_nascita" id="luogo_nascita" placeholder="Luogo di nascita" value="{{$cliente->utente->luogo_nascita}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="indirizzo" class="control-label">Indirizzo</label>
                        <input type="text" class="form-control" name="indirizzo" id="indirizzo" placeholder="Indirizzo" value="{{$cliente->utente->indirizzo}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="telefono" class="control-label">Telefono</label>
                        <input type="tel" maxlength="10" pattern="[0-9]*" class="form-control" name="telefono" id="telefono" placeholder="Telefono" value="{{$cliente->utente->telefono}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="email" class="control-label">Email</label>*
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{$cliente->utente->email}}" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <input type="hidden" value="{{$cliente->user_id}}" name="user_id" id="user_id">
                    <div class="col-6"><p class="pull-right">* campi obbligatori</p></div>
                    <div class="col-6"><button type="submit" id="modificaProfilo" class="btn btn-primary float-right">Conferma</button></div>
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
            var formModificaProfilo = $('#formModificaProfilo');
            formModificaProfilo.submit(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: '/cliente/modifica',
                    data: formModificaProfilo.serialize(),
                    success: function (data) {
                        console.log(data);
                        if(data==true){
                            console.log('Submission was successful.');
                            alert("Profilo modificato con successo!");
                            window.location.replace('/cliente');
                        }else{
                            alert(data);
                        }
                    },
                    error: function (data) {
                        console.log('An error occurred.');
                        console.log(data);
                        alert("Impossibile modificare il profilo!");
                    },
                });
            });
        });
    </script>
@stop
