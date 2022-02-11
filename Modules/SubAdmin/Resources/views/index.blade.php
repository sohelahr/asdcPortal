@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Staff</h3>
		@endslot
            <li class="breadcrumb-item active" aria-current="page">Staff</li>
	@endcomponent
    <div class="card">
        <div class="d-flex p-1 m-0 border header-buttons">
            <div>
                <button class="btn bg-white" type="button" data-bs-toggle="modal" data-bs-target="#subadmincreate">
                    <i class="fa fa-plus btn-icon-prepend"></i>
                    Add Staff
                </button>
            </div>
        </div>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger dark" role="alert">
                <p>{{ $error }}</p>
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endforeach
        @endif
        <div class="card-body"> 
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="bg-primary">
                        <tr>
                            <th>Name</th>
                            <th>Designation-Role</th>
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
                                <td>
                                    {{$subadmin->designation}}
                                </td>
                                <td>{{$subadmin->email}}</td>
                                <td class="d-flex">
                                    <a class="btn text-success" href="{{route('permissions',$subadmin->id)}}">
                                        <i class="fa fa-lock"></i>
                                    </a>
                                    <button class="btn text-primary" onclick="EditSubAdmin({{$subadmin->id}})">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <form action="{{url('subadmin/delete/'.$subadmin->id)}}" method="post">
                                        @csrf
                                        <button type=submit class="btn text-danger">
                                            <i class="fa fa-trash"></i>
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

    <div id="subadmincreate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="course-create-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="subadmin-create-title">Add Staff User</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                <form method="POST" action="{{route('subadmin_create')}}" id="subadmin">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="name">Name</label>
                                <input id="name" class="form-control" type="text" name="name" >
                            </div>
                            <div class="form-group col-6">
                                <label for="name">Designation-Role</label>
                                <select id="designation" class="form-control" name="designation">
                                    <option value="">Choose an option</option>
                                    <option value="Additional Director">Additional Director</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Receptionist">Receptionist</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="email">Email</label>
                                <input id="email" class="form-control" type="text" name="email" >
                            </div>
                            <div class="form-group">
	                            <label>Password</label>
	                            <div class="input-group">
	                                <span class="input-group-text"><i class="icon-lock"></i></span>
                                    
                                    <input type="password" class="form-control" id="password"
                                         name="password" required="" placeholder="*********">
                                    <div id="pwd_visibility" class="hide">
                                        <i class="fa fa-eye"></i>
                                    </div>
	                                <div class="invalid-feedback">Please enter password.</div>
	                            </div>
	                        </div>
                            
	                        <div class="form-group">
	                            <label>Confirm Password</label>
	                            <div class="input-group">
	                                <span class="input-group-text"><i class="icon-lock"></i></span>
                                    
                                    <input type="password" class="form-control" id="password_confirmation"
                                         name="password_confirmation" required="" placeholder="*********">
                                    <div id="pwd_confirm_visibility" class="hide">
                                        <i class="fa fa-eye"></i>
                                    </div>
	                                <div class="invalid-feedback">Please confirm password.</div>
	                            </div>
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

                    <div class="modal-header">
                        <h5 class="modal-title" id="course-edit-title">Edit Staff Details</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                <form method="POST"  id="edit-form" action="{{url('course/edit/')}}">
                    @csrf
                    <div class="modal-body">
                        <h5 class="text-danger" id="showtext">Please Wait...</h5>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="name">Name</label>
                                <input id="edit-name" class="form-control form-control-sm" type="text" name="name" >
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="email">Email</label>
                                <input id="edit-email" class="form-control form-control-sm" type="text" name="email">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="name">Designation-Role</label>
                                <select id="edit-designation" class="form-control" name="designation">
                                    <option value="">Choose an option</option>
                                    <option value="Additional Director">Additional Director</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Receptionist">Receptionist</option>
                                </select>
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
        function Notify(title,msg,status){
            $.notify({
                    title:title,
                    message:msg
                },
                {
                    type:status,
                    allow_dismiss:true,
                    newest_on_top:false ,
                    mouse_over:true,
                    showProgressbar:false,
                    spacing:10,
                    timer:2000,
                    placement:{
                        from:'top',
                        align:'center'
                    },
                    offset:{
                        x:30,
                        y:30
                    },
                    delay:1000 ,
                    z_index:10000,
                    animate:{
                        enter:'animated pulse',
                        exit:'animated bounce'
                    }
            });
        }
        @if(\Illuminate\Support\Facades\Session::has('created'))
            Notify('Created','Subadmin Was Successfully Created','success') 
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            Notify('Updated','Subadmin Was Successfully Updated','info') 
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            Notify('Deleted','Subadmin Was Successfully Deleted','warning')
        @elseif(\Illuminate\Support\Facades\Session::has('error'))
            Notify('Danger','Something Went Wrong ','danger')
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
                    console.log(data)
                    $("#edit-form").attr("action", `{{url('subadmin/edit/${course_id}')}}`);
                    $("#edit-name").val(data.name);
                    $("#edit-email").val(data.email);
                    $("#edit-designation").empty().html(`
                        <option value="Additional Director" ${(data.designation == "Additional Director" ) ? 'selected' : null }>Additional Director</option>
                        <option value="Administrator" ${(data.designation == "Administrator" ) ? 'selected' : null }>Administrator</option>
                        <option value="Receptionist" ${(data.designation == "Receptionist" ) ? 'selected' : null }>Receptionist</option>
                    `);
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
                    designation:{
                        required:true,
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
                        designation:{
                            required:'designation is required',
                        },
                        password:{ 
                            required: "Please enter a password",
                        },

                    } 

            });
            $('#edit-form').validate({
                errorClass: "text-danger pt-1",
                rules: {     
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    designation:{
                        required:true,
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
                        designation:{
                            required:'designation is required',
                        },
                        password:{ 
                            required: "Please enter a password",
                        },

                    } 

            });
        });
        
    </script>
    
@endsection