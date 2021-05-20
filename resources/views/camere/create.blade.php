@extends('layouts.app')

@section('thousand_sunny_content')
<a href="/camere" class="btn btn-outline-secondary" style="margin-left: 10px">Indietro</a>
<br>
<br>
<div class="col-12">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Aggiungi una nuova camera</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="exampleInputFile">Inserisci immagine</label>
                    <div class="input-group">
                        <form method="POST" enctype="multipart/form-data" id="formCaricaImmagine">
                            @csrf
                            <input type="file" name="image">
                            <button class="btn btn-primary" type="submit">Carica</button>
                        </form>
                    </div>
                    <span id="message" style="margin-top: 20px"></span>
                </div>
            </div>
            <form id="formAggiungiCamera">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="numero" class="control-label">N° camera</label>
                        <input type="number" min="1" maxlength="11" class="form-control" name="numero" id="numero" placeholder="Numero" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="numero_letti" class="control-label">N° posti letto</label>
                        <input type="number" min="1" maxlength="11" class="form-control" name="numero_letti" id="numero_letti" placeholder="Posti letto" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="piano" class="control-label">Piano</label>
                        {{{Form::select('piano', $camera_piano_enum, '', [ 'class' => 'form-control', 'placeholder' => 'Seleziona un piano', 'required' ])}}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="costo_a_notte" class="control-label">Costo a notte</label>
                        <input type="number" min="1" maxlength="11" class="form-control" name="costo_a_notte" id="costo_a_notte" placeholder="Costo a notte" required>
                    </div>
                    <div class="col-md-8 form-group">
                        <label for="descrizione" class="control-label">Descrizione</label>
                        <input type="text" class="form-control" name="descrizione" id="descrizione" placeholder="Descrizione" required>
                    </div>
                </div>
                <span id="image_name" style="display:none"></span><input type="hidden" value="" name="path_foto" id="path_foto">
                <button type="submit" id="aggiungiCamera" class="btn btn-primary float-right">Aggiungi</button>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-vertical-centered" id="modal_gia_presente" role="alertdialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <br><h4 class="modal-title"><span id="messaggio"></span></h4><br>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Chiudi</span></button>
            </div>
        </div>
    </div>
</div>
@stop
    
@section('js')
    <script>
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
         
        $(document).ready(function() {
            $('#formCaricaImmagine').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:"carica-immagine",
                    method:"POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(data){
                        $('#message').css('display', 'block');
                        $('#message').html(data.message);
                        $('#message').addClass(data.class_name);
                        $('#image_name').html(data.image_name);
                    }
                })
            });

            var formAggiungiCamera = $('#formAggiungiCamera');
            formAggiungiCamera.submit(function (e) {
                var nome = $('#image_name').html();
                $('#path_foto').val(nome);
                
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'post',
                    url: 'aggiungi-camera',
                    data: formAggiungiCamera.serialize(),
                    success: function (data) {
                        console.log(data);
                        if(data==true){
                            console.log('Submission was successful.');
                            alert("Camera inserita con successo!");
                            window.location.replace('/camere');
                        }else{
                            alert(data);
                        }
                    },
                    error: function (data) {
                        console.log('An error occurred.');
                        console.log(data);
                        alert("Impossibile inserire la camera!");
                    },
                });
            });
        });
    </script>
@stop
