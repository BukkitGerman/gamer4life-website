@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col align-self-start">
                        {{ __('Topics') }}
                        </div>    
                        <div class="col align-self-end text-right">
                            <!--a href="{{ route('createPost') }}" class="btn btn-primary">Ober Thema Erstellen</a-->
                            @if(auth()->user()->can('topic.create'))
                            <a href="{{ route('createTopic') }}" class="btn btn-primary">Thema Erstellen</a>
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
                    @if (session()->get('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session()->get('error')}}
                        </div>
                    @endif
                        <div class="list-group">
                            @foreach($arr as $head_topic)
                            <button class="list-group-item list-group-item-action active" disabled>{{ key($head_topic) }}</button>
                                @foreach($head_topic as $topics)
                                    @foreach($topics as $topic)
                                        <a href="{{ url('forum/'.strtolower($topic[0]) )}}" class="list-group-item list-group-item-action">
                                            <div class="row">
                                                <div class="col">{{ $topic[0] }}</div>
                                                <div class="col text-right"><span class="badge badge-light">{{ $topic[1] }}</span></div>
                                            </div>
                                        </a>
                                    @endforeach
                                    <br>
                                @endforeach
                            @endforeach
                            
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection