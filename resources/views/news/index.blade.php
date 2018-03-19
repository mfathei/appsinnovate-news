@extends('layouts.app')

@section('content')


            <div class="modal" id="confirmDelete" data-keyboard="false" data-backdrop="static" tabindex="-1">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Confirm Delete</h4>
                        </div>
                        <div class="modal-body">
                            <form id="deletionForm" method="POST" action="/news/delete">
                                {{ csrf_field() }}
                                <input id="doctor-delete-id" name="doctor-delete-id" type="hidden" value="0"/>
                                <p>Are you sure you want to delete this ? </p>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="submitDelete" type="button" class="btn btn-primary">Delete</button>
                            <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">Appsinnovate News</div>

                <div class="panel-body">
                    <h1  class="page-heading center" align="center">Manage News</h1>
                    <div style="width: 100%;
                         margin-bottom: 50px;">
                        <a href='/home' class="float-right"><i class="glyphicon glyphicon-arrow-left" area-hidden="true"></i>Back</a>
                    </div>
                    @include('layouts.error')

                    <table id="staffId" class="table table-bordered table-responsive table-striped">
                    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Details</th>
            <th>Created</th>
            
            <th>
                <a href="/news/create/">
                    <i class="fa fa-user-plus green"></i>
                </a>

                </a>
            </th>

            </tr>
            </thead>
            <tbody>
            @foreach($news as $st)
            <tr>
                <td>{{ $st->id }}</td>
                <td>{{ $st->title }}</td>
                <td>{{ \Illuminate\Support\Str::words($st->body, 20,'...') }}</td>
                <td>{{ $st->created_at }}</td>
                
                <td>
                    <a href="/news/edit/{{$st->id}}">
                        <i class="glyphicon glyphicon-pencil" aria-hidden="true" title="Edit record"></i>
                    </a>
                    <a href="#">
                        <i class="glyphicon glyphicon-trash red" id="{{ $st->id }}" aria-hidden="true"
                           title="Delete record"
                           data-target="#confirmDelete" data-toggle="modal"></i>
                    </a>

                </td>

                </tr>
            @endforeach
            </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section ('scripts')

    <script type="text/javascript">
        
        $(document).ready(function () {
            $('#staffId').DataTable({
            });

            $('.glyphicon.glyphicon-trash.red').click(function () {
                var id = $(this).attr('id');
                $('#doctor-delete-id').attr('value', id);
//                $('#confirmDelete').toggle('show');
//                alert(id);
            });

            $('#submitDelete').click(function () {
                $('#deletionForm').submit();
                $('confirmDelete').modal('hide');
            });
        });


    </script>

@endsection
