@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Sub Admins
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sub Admins</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
            <div class="float-right my-2">
                <button class="btn btn-outline-primary btn-fw" type="button" data-toggle="modal" data-target="#subadmin-create">
                     + Create
                </button>
            </div>    
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subadmins as $subadmin)
                            <tr>
                                <td>
                                    {{$subadmin->name}}
                                </td>
                                <td>{{$subadmin->email}}</td>
                                <td class="d-flex p-1">
                                    <a class="btn btn-info btn-rounded p-2 mr-3" href="{{route('permissions',$subadmin->id)}}">
                                        <i class="fas fa-lock"></i>
                                    </a>
                                    <button class="btn btn-dark btn-rounded p-2 mr-2" onclick="EditSubAdmin({{$subadmin->id}})">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <form action="{{url('subadmin/delete/'.$subadmin->id)}}" method="post" class="ml-2">
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

    <div id="subadmin-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="course-create-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{route('subadmin_create')}}" id="subadmin">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="subadmin-create-title">Create SubAdmin</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" class="form-control form-control-sm" type="text" name="name" >
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="email">Email</label>
                                <input id="email" class="form-control form-control-sm" type="text" name="email" >
                            </div>
                            <div class="form-group col-6">
                                <label for="slug">Password</label>
                                <input id="slug" class="form-control form-control-sm" type="password" name="password" >
                            </div>
                            <div class="form-group col-6">
                                <label for="slug">Confirm Password</label>
                                <input id="slug" class="form-control form-control-sm" type="password" name="password_confirmation" >
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Submit" class="btn btn-primary">    
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="subadmin-edit" class="modal" tabindex="-1" role="dialog" aria-labelledby="subadmin-edit-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST"  id="edit-form" action="{{url('course/edit/')}}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="course-edit-title">Edit SubAdmin</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-danger" id="showtext">Please Wait...</h5>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="edit-name" class="form-control form-control-sm" type="text" name="name" >
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="email">Email</label>
                                <input id="edit-email" class="form-control form-control-sm" type="text" name="email">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Submit" class="btn btn-primary" >    
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('jcontent')
    <script>
        @if(\Illuminate\Support\Facades\Session::has('created'))    
            $.toast({
                heading: 'Created',
                text: 'Subadmin Was Successfully Created',
                position:'top-right',
                icon: 'success',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            $.toast({
                heading: 'Updated',
                text: 'SubAdmin Was Successfully Updated',
                position:'top-right',
                icon: 'info',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            $.toast({
                heading: 'Deleted',
                text: 'SubAdmin Was Successfully Deleted',
                position:'top-right',
                icon: 'warning',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
            
        @elseif(\Illuminate\Support\Facades\Session::has('error'))
            $.toast({
                heading: 'Danger',
                text: 'Something Went Wrong ',
                position:'top-right',
                icon: 'danger',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @endif

        function EditSubAdmin(subadmin_id){
            getEditData(subadmin_id);
            $("#subadmin-edit").modal('show');
        }

        function getEditData(course_id){
            $.ajax({
                type: "get",
                url: `{{url('subadmin/edit/${course_id}')}}`,
                beforeSend: function () {
                    $('#showtext').show();
                },
                success: function (response) {
                    data = JSON.parse(response);
                    $("#edit-form").attr("action", `{{url('subadmin/edit/${course_id}')}}`);
                    $("#edit-name").val(data.name);
                    $("#edit-email").val(data.email);
                },
                complete: function () {
                    $('#showtext').hide();
                },
            });
        }



        $(document).ready(function (){
        $('#subadmin').validate({
            errorClass: "text-danger pt-1",
            rules: {     
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },

                password: {
                    required: true,
                },
            },

                messages: {
                    name:{
                        required: "Please enter your name",
                    },

                    email:{
                        required: "Please enter email",
                    },

                    password:{ 
                        required: "Please enter a password",
                    },

                } 

        });
    });
        
    </script>
    
@endsection