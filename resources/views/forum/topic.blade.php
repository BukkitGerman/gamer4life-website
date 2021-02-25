@extends('layouts.forum')

@section('_content')
@if(empty($posts))
    <a class="list-group-item list-group-item-action bg-info text-dark disabled">Noch keine Beiträge vorhanden!</a>
@else
    @foreach($posts as $post)
        <a href="{{ url('/forum/'.$topic.'/'.$post['id'])}}" class="list-group-item list-group-item-action bg-secondary text-white">{{ $post['title'] }}</a>
        <br/>
    @endforeach
@endif
    
@endsection