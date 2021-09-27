@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Qualifications
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Qualifications</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        
        <div class="card-body">
            <div class="float-right my-2">
                <button class="btn btn-success btn-icon-text" type="button" data-toggle="modal" data-target="#qualification-create">
                    Create
                    <i class="fa fa-plus btn-icon-prepend"></i>
                </button>
            </div>    
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($qualifications as $qualification)
                            <tr>
                                <td>{{$qualification->name}}</td>
                                <td class="d-flex p-1">
                                    <button class="btn btn-dark btn-rounded p-2" onclick="Editqualification({{$qualification->id}})">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <form action="{{url('qualification/delete/'.$qualification->id)}}" method="post" class="ml-2">
                                        @csrf
                                        <button type=submit class="btn btn-danger btn-rounded p-2">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="qualification-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="qualification-create-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{url('qualification/create')}}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="qualification-create-title">Create Qualification</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" class="form-control form-control-sm" type="text" name="name" placeholder="eg: BCA">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Submit" class="btn btn-primary">    
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

    <div id="qualification-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="document-create-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{url('qualification/edit')}}" id="edit-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="document-create-title">Edit Document</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-danger" id="showtext">Please Wait...</h5>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="edit-name" class="form-control form-control-sm" type="text" name="name" placeholder="eg: Bachelor of Science">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Submit" class="btn btn-primary">    
                    </div>
                </form>
            </div>
        </div>
    </div>

@section('jcontent')
    <script>
        
        
        function Editqualification(qualification_id){
            getEditData(qualification_id);
            $("#qualification-edit").modal('show');
        }

        function getEditData(qualification_id){
            console.log(qualification_id)
            $.ajax({
                type: "get",
                url: `{{url('qualification/edit/${qualification_id}')}}`,
                beforeSend: function () {
                    $('#showtext').show();
                },
                success: function (response) {
                    data = JSON.parse(response);

                    $("#edit-form").attr("action", `{{url('qualification/edit/${qualification_id}')}}`);
                    $("#edit-name").val(data.name);
                },
                complete: function () {
                    $('#showtext').hide();
                },
            });
        }
        
    </script>
    
@endsection