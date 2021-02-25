@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 justify-content-center">
            <div class="card p-3">
                <div class="d-flex align-items-center">
                    <div class="image"> <img src="{{ asset('images/avatars/'.$user->avatar) }}" style="border-radius:50%; border-style: solid;" width="155"> </div>
                    <div class="ml-3 w-100">
                        <h4 class="mb-0 mt-0">{{ $user->name}}</h4> <span>Senior Journalist</span>
                        <div class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">
                            <div class="d-flex flex-column"> <span class="post">Posts</span> <span class="number1">{{ $post }}</span> </div>
                            <div class="d-flex flex-column"> <span class="followers">Followers</span> <span class="number2"> {{ $follower }}</span> </div>
                            <div class="d-flex flex-column"> <span class="rating"></span>TS3<span class="number3">
                            @if($ts)
                            ✔ 
                            @else
                            ✘
                            @endif
                            </span> </div>
                        </div>
                        @if($current != $user)
                            @if(!($follow))
                                <form method="POST">
                                    @csrf
                                    <div class="button mt-2 d-flex flex-row align-items-center"> <button class="btn btn-sm btn-outline-primary w-100" formaction="{{ route('chat') }}" type="submit">Chat</button> <button name="profile_id" value="{{ $user->id }}" type="submit" class="btn btn-sm btn-primary w-100 ml-2" formaction="{{ route('follow') }}">Follow</button> </div>
                                </form>
                            @endif
                            @if($follow)
                                <form method="POST">
                                    @csrf
                                    <div class="button mt-2 d-flex flex-row align-items-center"> <button class="btn btn-sm btn-outline-primary w-100">Chat</button> <button name="profile_id" value="{{ $user->id }}" type="submit" class="btn btn-sm btn-primary w-100 ml-2" formaction="{{ route('unfollow') }}">Unfollow</button> </div>
                                </form>
                            @endif
                        @elseif($current == $user)
                                    <a href="/profileedit" class="mt-2 btn btn-sm btn-outline-primary w-25" style="margin-left: 37%">Edit</a>
                        @endif
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        Über mich
                    </div>
                    <div class="card-body">
                        {!! $about['about'] !!}
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection