@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @yield('dashboard.nav')
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @can('administrator')
                        Hello {{ $usr->name }}!
                    @endcan
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
    @yield('content_')
@endsection