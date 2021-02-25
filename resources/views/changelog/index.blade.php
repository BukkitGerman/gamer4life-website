@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            {{ __('Changelogs') }}
                        </div>
                        <div class="col text-right">
                        @if(!is_null(Auth()->user()))
                            @if(auth()->user()->can('changelog.create'))
                                <a href="{{route('changelogs.create')}}" class='btn btn-primary'>Erstellen</a>
                            @endif
                        @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session()->get('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session()->get('success')}}
                        </div>
                        @endif
                        <div class="list-group">
                        @foreach($changelogs as $changelog)
                            <a href="{{ url('changelog/'.strtolower($changelog['id']) )}}" class="list-group-item mb-1 list-group-item-action list-group-item-secondary">
                                <div class="row">
                                    <div class="col">{{ $changelog['title'] }}</div>
                                    <div class="col text-right">{{ $changelog['date'] }} </div>
                                </div>
                            </a>
                        @endforeach
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection