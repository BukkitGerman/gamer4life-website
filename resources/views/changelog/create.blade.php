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
    <h1 class="text-left col">Changelog Hinzufügen</h1>
    </div>
    <form action="{{route('changelogs.store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="title" class="col-form-label">Titel</label>
            <input class="form-control" type="text" value="" id="title" name='title' required/>
        </div>
        <div class="form-group">
            <label for="title" class="col-form-label">Datum</label>
            <input type="date" name='date' id='date' class="form-control" required/>
        </div>
        <div class="form-group">
            <label for="text" class="col-form-label">Text</label>
            <textarea class="form-control summernote" value="" id="text" name='text' required></textarea>
            <script>
                $('.summernote').summernote({
                    placeholder: 'Hello {{Auth::User()->name}}!',
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
        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Submit</button>
    </form>
</div>
@endsection