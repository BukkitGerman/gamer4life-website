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
        <h1 class="text-left col">User Hinzufügen</h1>
        </div>
        <form action="{{route('users.store')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="name" class="col-form-label">Name</label>
                <input class="form-control" type="text" value="{{old('name')}}" id="name" name='name'>
            </div>
            <div class="form-group">
                <label for="email" class="col-form-label">E-Mail</label>
                <input class="form-control" type="email" value="{{old('email')}}" id="email" name='email'>
            </div>
            <div class="form-group">
                <label for="password" class="col-form-label">Passwort</label>
                <input class="form-control" type="password" value="{{old('password')}}" id="password" name='password'>
            </div>
            <div class="form-group">
                <label for="password_confirmation" class="col-form-label">Password Confirmation</label>
                <input class="form-control" type="password" value="{{old('password_confirmation')}}" id="password_confirmation" name='password_confirmation'>
            </div>
            <div class="form-group">
                <label for="permissions" class="col-form-label">Permissions</label>
                @foreach($permissions as $permission)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="{{$permission->name}}" name="permissions[]" value="{{$permission->id}}">
                        <label class="custom-control-label" for="{{$permission->name}}">{{$permission->name}}</label>
                    </div>
                @endforeach
            </div>
            <div class="form-group">
                <label for="groups" class="col-form-label">Groups</label>
                @foreach($groups as $group)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="{{$group->name}}" name="groups[]" value="{{$group->id}}">
                        <label class="custom-control-label" for="{{$group->name}}">{{$group->name}}</label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Submit</button>
        </form>
    </div>
@endsection