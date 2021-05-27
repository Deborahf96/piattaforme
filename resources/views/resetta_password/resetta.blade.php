@extends('layouts.app')

@section('thousand_sunny_content')


@if(session('successPassword'))
<br>
<div class="alert alert-success">{{session('successPassword')}}</div>
@endif
@if(session('warningPassword'))
<br>
<div class="alert alert-warning">{{session('warningPassword')}}</div>
@endif
<div class="d-flex justify-content-center">
    <div class="col-6">
        <div class="card card-outline card-primary">
            <div class="card-header d-flex p-0">
                <h5 class="card-title p-3"><b>Modifica Password</b></h5>
            </div>
            <div class="card-body">
                <form action="/modifica-password" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="InputPasswordOld">Password corrente</label>
                        <input name="password_corrente" type="password" class="form-control" id="password_corrente" placeholder="Password corrente" required>
                    </div>
                    <div class="form-group">
                        <label for="InputPassword">Nuova password</label>
                        <input name="password" type="password" minlength="8" class="form-control" id="password" placeholder="Nuova password" required>
                    </div>
                    <div class="form-group">
                        <label for="InputPasswordConfirm">Ripeti password</label>
                        <input name="password_confirm" type="password" minlength="8" class="form-control" id="password_confirm" placeholder="Ripeti password" required>
                    </div>
                <input type="hidden" value="{{$user->id}}" name="id" id="id">
                <button type="submit" class="btn btn-primary float-right">Conferma</button>
                </form>
            </div>
        </div>
    </div>    
</div>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js" integrity="sha256-o1euaz1vwPXBTxRl9OxyDQuac7lF8i92X56aky0gPEE=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/language/it_IT.js" integrity="sha256-GXV5lpVTBuu3MxhUL4FwyOVI1cAgALwQfJvYhYQWsWs=" crossorigin="anonymous"></script>
@stop
