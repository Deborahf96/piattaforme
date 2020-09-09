@extends('layouts.app')

@php $cliente=Auth::user()->name
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('Benvenuto!')}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __("Hai eseguito l'accesso come " .$cliente) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
