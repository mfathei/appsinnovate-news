@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">Appsinnovate News</div>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div style="width: 100%;
                         margin-bottom: 50px;">
                        <a href='/news/create' class="btn btn-primary float-right">Add News</a>
                    </div>

                    @foreach($news as $post)

                        @include ('news.post')

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
