@extends('layouts.app')

@section('thousand_sunny_content')
<div class="col-12">
    <a href="/camere" class="btn btn-outline-secondary">Torna a camere</a>
    <br>
    <br>
    <div class="card card-outline card-primary">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Modifica una camera</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="exampleInputFile">Modifica immagine</label>
                    <div class="input-group">
                        <form method="POST" enctype="multipart/form-data" id="formCaricaImmagine">
                            @csrf
                            <input type="file" name="image">
                            <button class="btn btn-primary" type="submit">Carica</button>
                        </form>
                    </div>
                    <span id="message" style="margin-top: 20px"></span>
                </div>
                <div class="col-md-4 form-group">
                    <button type="button" name="visualizzaImmagine" data-target="#visualizzaImmagine" data-toggle="modal" class="btn btn-warning float-left" style="margin-right: 10px">Visualizza immagine corrente</button>
                </div>
            </div>
            <form id="formModificaCamera">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="numero" class="control-label">N° camera</label>
                        <input type="number" min="1" maxlength="11" class="form-control" name="numero" id="numero" placeholder={{$camera->numero}} value={{$camera->numero}} required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="numero_letti" class="control-label">N° posti letto</label>
                        <input type="number" min="1" maxlength="11" class="form-control" name="numero_letti" id="numero_letti" placeholder={{$camera->numero_letti}} value={{$camera->numero_letti}} required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="piano" class="control-label">Piano</label>
                        {{{Form::select('piano', $camera_piano_enum, $camera->piano, [ 'class' => 'form-control', 'placeholder' => 'Seleziona un piano', 'required' ])}}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="costo_a_notte" class="control-label">Costo a notte</label>
                        <input type="number" min="1" maxlength="11" class="form-control" name="costo_a_notte" id="costo_a_notte" placeholder={{$camera->costo_a_notte}} value={{$camera->costo_a_notte}} required>
                    </div>
                    <div class="col-md-8 form-group">
                        <label for="descrizione" class="control-label">Descrizione</label>
                        <input type="text" class="form-control" name="descrizione" id="descrizione" placeholder={{$camera->descrizione}} value={{$camera->descrizione}} required>
                    </div>
                </div>
                <span id="image_name" style="display:none"></span><input type="hidden" value="" name="path_foto" id="path_foto">
                <input type="hidden" value={{$camera->id}} name="id" id="id">
                <button type="submit" id="modificaCamera" class="btn btn-primary float-right">Conferma</button>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="visualizzaImmagine" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Immagine corrente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                @if($camera->path_foto==null)
                    <img src="../../img/camere/default.png" alt="Immagine" style="border: 1px solid gray; width:250px;">
                @else
                    <img src="../../img/camere/{{$camera->path_foto}}" alt="Immagine" style="border: 1px solid gray; width:250px;">
                @endif
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">OK</button></div>
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
                    url:"/camere/carica-immagine",
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

            var formModificaCamera = $('#formModificaCamera');
            formModificaCamera.submit(function (e) {
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
                    url: '/camere/modifica-camera',
                    data: formModificaCamera.serialize(),
                    success: function (data) {
                        console.log(data);
                        if(data==true){
                            console.log('Submission was successful.');
                            alert("Camera modificata con successo!");
                            window.location.replace('/camere');
                        }else{
                            alert(data);
                        }
                    },
                    error: function (data) {
                        console.log('An error occurred.');
                        console.log(data);
                        alert("Impossibile modificare la camera!");
                    },
                });
            });
        });
    </script>
@stop
