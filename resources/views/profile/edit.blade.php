@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <img src="/images/avatars/{{ $user->avatar }}" style="width:150px; height:150px; float:left; border-radius:50%; border-style: solid; margin-right:25px;">
            <h2>{{ $user->name }}'s Profile</h2>
            <form enctype="multipart/form-data" action="/profile/{{ $user->name }}" method="POST">
                <div class="row">
                    <div class="col">
                        <label for="avatar">Update Profile Image</label>
                        <input type="file" name="avatar">
                    </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
                <div class="row">
                    <br>
                </div>
                <div class="row">
                    <div class="col">
                    <label for="about" class="col-form-label"><h4>Über dich</h4></label>
                    <textarea class="form-control summernote" value="" id="about" name='about'>{{ $about }}</textarea>
                    <script>
                        $('.summernote').summernote({
                            placeholder: 'Erzähle uns etwas über dich, {{Auth::User()->name}}!',
                            tabsize: 2,
                            height: 200,
                            toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link']],
                            ['view', [ 'codeview', 'help']]
                            ]
                        });
                    </script>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-2">
                        <input type="submit" class="w-100 mt-2 pull-right btn btn-sm btn-primary">
                    </div>
                </div>    
            </form>
            <form action="{{route('teamspeak_verify_code')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="code" class="col-form-label">Code</label>
                            <input class="form-control" type="text" value="" id="code" name='code' required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Submit</button>
            </form>
            <form action="{{ route('teamspeak_verify') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="code" class="col-form-label">TS3-UID</label>
                    <input class="form-control" type="text" value="{{ $uid }}" id="uid" name='uid' required>
                </div>
                <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Get Code</button>
            </form>
        </div>
    </div>
</div>
@endsection