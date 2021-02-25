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
        <h1 class="text-left col">User editieren</h1>
        </div>
        <form action="{{route('users.update', $user->id)}}" method="post">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="name" class="col-form-label">Name</label>
                <input class="form-control" type="text" value="{{$user->name}}" id="name" name='name'>
            </div>
            <div class="form-group">
                <label for="email" class="col-form-label">E-Mail</label>
                <input class="form-control" type="email" value="{{$user->email}}" id="email" name='email'>
            </div>
            <div class="form-group">
                <label for="permissions" class="col-form-label">Permissions</label>
                @foreach($permissions as $permission)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="{{$permission->name}}" name="permissions[]" value="{{$permission->id}}" 
                        @if($user->hasPermission($permission->id)) checked @endif>
                        <label class="custom-control-label" for="{{$permission->name}}">{{$permission->name}}</label>
                    </div>
                @endforeach
            </div>
            <div class="form-group">
                <label for="groups" class="col-form-label">Groups</label>
                @foreach($groups as $group)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="{{$group->name}}" name="groups[]" value="{{$group->id}}" 
                        @if($user->hasGroup($group->id)) checked @endif>
                        <label class="custom-control-label" for="{{$group->name}}">{{$group->name}}</label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Submit</button>
        </form>
    </div>
@endsection