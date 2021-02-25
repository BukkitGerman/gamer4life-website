@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">{{ $changelog['title'] }}</div>
                        <div class="col text-right">{{ $changelog['date'] }} </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session()->get('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session()->get('success')}}
                        </div>
                        @endif
                        {!! $changelog['body'] !!}
                </div>
                <div class="card-footer text-muted text-center">
                    <a href="{{ url('/profile/'.$changelog['author']) }}" class="badge badge-light" style="font-size: 16px">{{ $changelog['author'] }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection