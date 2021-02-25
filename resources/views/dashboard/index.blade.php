@extends('layouts.dashboard')
@section('content_')
@section('dashboard.nav')
<ul class="nav nav-pills nav-fill">
    <li class="nav-item">
        <a class="nav-link list-group-item list-group-item-action px-2 text-light bg-primary btn btn-primary" href="{{ route('dashboard.index') }}">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link list-group-item list-group-item-action bg-light px-2" href="{{route('permissions.index')}}">Permissions</a>
    </li>
    <li class="nav-item">
        <a class="nav-link list-group-item list-group-item-action bg-light px-2" href="{{route('users.index')}}">Users</a>
    </li>
    <li class="nav-item">
    <a class="nav-link list-group-item list-group-item-action bg-light px-2" href="{{route('groups.index')}}">Groups</a>
    </li>
</ul>
@endsection
@endsection