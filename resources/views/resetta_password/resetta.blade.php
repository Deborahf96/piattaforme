@extends('layouts.app')

@section('thousand_sunny_content')

<div class="d-flex justify-content-center">
    <div class="col-6">
        <div class="card">
            <div class="card-header"><b>Modifica Password</b></div>
            <div class="card-body">
                {!! Form::open(['action' => ['ResettaPasswordController@cambia_password', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                <div class="form-group">
                    {!! Form::label('password', 'Inserisci nuova password') !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Ripeti password') !!}
                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                </div>
                {{ Form::submit('Conferma', [ 'class' => 'btn btn-primary float-right']) }}
                {!! Form::close() !!}
            </div>
        </div>
    </div>    
</div>
@endsection