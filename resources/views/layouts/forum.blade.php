@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col align-self-start">
                            {{ __('Posts') }}
                        </div>
                        <div class="col align-self-end text-right">
                            
                            <form class="mb-0" action="{{route('topic.destroy', $topic_['id'])}}" method="post">
                                @csrf
                                @permission('post.create')
                                <a href="{{ route('createPost') }}" class="btn btn-primary">Erstellen</a>
                                @endpermission
                                @permission('topic.delete')
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit" onclick="return confirm('Wollen sie es löschen?')" 
                                    style="-webkit-apperance: none;">DELETE TOPIC</button>
                                @endpermission            
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <div class="list-group">
                            @yield('_content')
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection