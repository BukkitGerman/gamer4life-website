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
    <h1 class="text-left col">Post Hinzufügen</h1>
    </div>
    <form action="{{route('topic.store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="name" class="col-form-label">Name</label>
            <input class="form-control" type="text" value="" id="name" name='name' required>
        </div>
        <div class="form-group">
            <label for="topics" class="col-form-label">Thema</label>
            @foreach($head_topics as $head_topic)
                @if(auth()->user()->can('topic.create'))
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="{{ $head_topic['head_topic'] }}" name="topic" value="{{ $head_topic['id'] }}" required>
                        <label class="custom-control-label" for="{{$head_topic['head_topic']}}">{{$head_topic['head_topic']}}</label>
                    </div>
                @endif
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Submit</button>
    </form>
</div>
@endsection