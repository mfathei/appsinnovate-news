@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">Appsinnovate News</div>

                <div class="panel-body">
                    <h1  class="page-heading center" align="center">Add News</h1>
                    <div style="width: 100%;
                         margin-bottom: 50px;">
                        <a href='/home' class="float-right"><i class="glyphicon glyphicon-arrow-left" area-hidden="true"></i>Back</a>
                    </div>
                    @include('layouts.error')

                    <form id='create-form' method="post" action="/news/create/" data-validate="parsley">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="title">News Title </label>
                            <input type="text" class="form-control" id="title" name="title" required="" data-parsley-trigger="keyup" 
                                   data-parsley-minlength="5" data-parsley-maxlength="100" 
                                   data-parsley-minlength-message="Come on! You need to enter at least a 5 characters title.." value="{{ old('title') }}"/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">News Details</label>
                            <textarea class="form-control" id="summernote" name="body" required="" data-parsley-trigger="keyup" 
                                      data-parsley-minlength="20" data-parsley-maxlength="3000" 
                                      data-parsley-minlength-message="Come on! You need to enter at least a 20 character details.." value="{{ old('body') }}"></textarea>
                        </div>
                        <!--
                                                <div class="form-group">
                                                    <label for="exampleInputFile">File input</label>
                                                    <input type="file" id="exampleInputFile">
                                                    <p class="help-block">Example block-level help text here.</p>
                                                </div>-->
                        <button type="submit" class="btn btn-primary">Save</button>
                        <br/><br/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section ('scripts')

<script>

    $(document).ready(function () {
        $('#summernote').summernote({
            height: 250
        });
    });

    $(function () {
        $('#create-form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    });

</script>

@endsection