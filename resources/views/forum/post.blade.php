@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">{{ $post['title'] }}</div>
                        <div class="col text-right">
                            
                            <form class="mb-0" action="{{route('post.destroy', $post['id'])}}" method="post">
                                @csrf
                                @permission('post.edit')
                                <a href="{{ route('post.edit', $post['id']) }}" class='btn btn-primary'>EDIT</a>
                                @endpermission
                                @permission('post.delete')
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit" onclick="return confirm('Wollen sie es löschen?')" 
                                    style="-webkit-apperance: none;">DELETE</button>
                                @endpermission            
                            </form>
                        </div>
                    </div> 
                </div>
                <div class="card-body">
                    @if (session()->get('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session()->get('success')}}
                        </div>
                        @endif
                        {!! $post['body'] !!}
                </div>
                <div class="card-footer text-muted text-center">
                    <a href="{{ url('/profile/'.$post[0]['name']) }}" class="badge badge-light" style="font-size: 16px">{{ $post[0]['name'] }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection