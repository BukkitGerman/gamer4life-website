@extends('layouts.app')

@section('content')
<div class="container">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row align-item-center justify-content-start">
    <h1 class="text-left col">Teamspeak einbinden</h1>
    </div>
</div>
@endsection