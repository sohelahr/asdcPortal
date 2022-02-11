@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Courses</h3>
		@endslot
            <li class="breadcrumb-item active" aria-current="page">Courses</li>
	@endcomponent
    <div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
                    <div id="overlay-loader" class="d-none">
                        <div style="height: 100%;width:100%;background:rgba(121, 121, 121, 0.11);position: absolute;z-index:999;" class="d-flex justify-content-center align-items-center"> 
                            <div> 
                                <div class="loader-box">
                                    <div class="loader-7"></div>
                                </div>              
                            </div>
                        </div>
                    </div>
                    @if(\App\Http\Helpers\CheckPermission::hasPermission('create.documents'))
                        <div class="d-flex p-1 m-0 border header-buttons">
                            <div>
                                <button class="btn bg-white" type="button" data-bs-toggle="modal" data-bs-target="#course-create">
                                    <i class="fa fa-plus btn-icon-prepend"></i>
                                    Create
                                </button>
                            </div>
                        </div>
                    @endif
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
                        <div class="table-responsive">
                            <table class="display datatables" id="courses">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Duration</th>
                                        <th>Slug</th>
                                        <th>Timings</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="course-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="course-create-title" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="POST" action="#" {{-- action="{{url('course/create')}}" --}} id="course-form">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="course-create-title">Create Course</h5>
                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Name <sup class="text-danger">*</sup></label>
                                        <input id="name" class="form-control" type="text" name="name" placeholder="eg: Digital Marketing">
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="Duration">Duration <sup class="text-danger">*</sup></label>
                                            <input id="Duration" class="form-control" type="text" name="duration" placeholder="eg : 3 months">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="slug">Slug <sup class="text-danger">*</sup></label>
                                            <input id="slug" class="form-control" type="text" name="slug" placeholder="eg : DM">
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

                <div id="course-edit" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="course-edit-title" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="POST"  id="editform" action="{{url('course/edit/')}}">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="course-edit-title">Edit Course</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Name <sup class="text-danger">*</sup></label>
                                        <input id="edit_name" class="form-control form-control-sm" type="text" name="name" placeholder="eg: Digital Marketing">
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="Duration">Duration <sup class="text-danger">*</sup></label>
                                            <input id="edit_Duration" class="form-control form-control-sm" type="text" name="duration" placeholder="eg : 3 months">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="slug">Slug <sup class="text-danger">*</sup></label>
                                            <input id="edit_slug" class="form-control form-control-sm" type="text" name="slug" placeholder="eg : DM">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" value="Submit" class="btn btn-primary" >  
                                    <a class="btn btn-secondary" onclick="closeModal()">Close</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
        function closeModal(){
            $('#course-edit').modal('hide');
        }
        function deleteCourseConfirm(id){
            swal({
                title: "Warning",
                text: 'You sure want to delete',
                icon:'warning',
                buttons: ['Back','Yes I\'m Sure'],
                dangerMode: true,
                }).then((yes_delete) => {
                    if (yes_delete) {
                           $('#delete_form_'+id).submit();    
                    }
                    else
                    return null;
                });
        }
        @if(\Illuminate\Support\Facades\Session::has('created'))  
            Notify('Created','Course Was Successfully Created','success')  
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            Notify('Updated','Course Was Successfully Updated','info')  
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            Notify('Deleted','Course Was Successfully Deleted','warning')  
        @elseif(\Illuminate\Support\Facades\Session::has('prohibited'))
            Notify('Cannot Delete','This course already has registrations or admissions','warning')  
        @elseif(\Illuminate\Support\Facades\Session::has('error'))
            Notify('Danger','Something Went Wrong','danger')  
        @endif
        function EditCourse(course_id){
            getEditData(course_id);
        }

        function getEditData(course_id){
            $.ajax({
                type: "get",
                url: `{{url('course/edit/${course_id}')}}`,
                beforeSend: function () {
                    $('#overlay-loader').removeClass('d-none');
                    $('#overlay-loader').show();
                },
                success: function (response) {
                    data = JSON.parse(response);

                    $("#editform").attr("action", `{{url('course/edit/${course_id}')}}`);
                    $("#edit_name").val(data.name);
                    $("#edit_Duration").val(data.Duration);
                    $("#edit_slug").val(data.slug);
                    $("#course-edit").modal('show');
                },
                complete: function () {
                    $('#overlay-loader').hide();
                },
            });
        }

        $(document).ready(function (){
            $('#course-form').validate({
                errorClass: "text-danger pt-1",
                rules: {     
                    name: {
                        required: true,
                    },
                    duration: {
                        required: true,    
                    },

                    slug: {
                        required: true,
                    },
                },

                    messages: {
                        name:{
                            required: "Please enter course name",
                        },

                        duration:{
                            required: "Please enter duration",
                        },

                        slug:{ 
                            required: "Please enter a slug",
                        },

                    }
            });
            $('#editform').validate({
                errorClass: "text-danger pt-1",
                rules: {     
                    name: {
                        required: true,
                    },
                    duration: {
                        required: true,    
                    },

                    slug: {
                        required: true,
                    },
                },

                    messages: {
                        name:{
                            required: "Please enter course name",
                        },

                        duration:{
                            required: "Please enter duration",
                        },

                        slug:{ 
                            required: "Please enter a slug",
                        },

                    } 

            });
            $('#courses').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('course_data')}}",
                pageLength:'12',
                columnDefs: [{
                "defaultContent": "-",
                orderable:false,
                "targets": "_all"
                }],
                columns:[
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name',name:"name"},
                    {data:'Duration',name:'Duration'},
                    {data:'slug',name:'slug'},
                    {data:'coursetiming_perm',render:function(data,type,row){
                        if(data){
                            return `<a class="nav-link p-0" href="{{url('courseslot/${row.id}')}}">View</a>`;
                        }
                        else{
                            return
                        }
                    },name:'coursetiming_perm'},
                    {data: 'perm',render:function(data,type,row){
                        return `<div>
                                    <div  class="d-flex p-0 m-0">
                                        ${data.edit_perm ? 
                                        `<button class="form-btn form-btn-warning ms-4 me-2" onclick="EditCourse(${row.id})">
                                            <i class="fa fa-pencil"></i>
                                        </button>` 
                                        : null}
                                        ${data.delete_perm ? 
                                        
                                        `<div class="ml-2">
                                                    <button type=submit class="form-btn form-btn-danger ms-2" onclick="deleteCourseConfirm(${row.id})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                            </div>        
                                                <form action='course/delete/${row.id}' id='delete_form_${row.id}' method="post" class="d-none">
                                                    @csrf
                                                </form>
                                        `: null}
                                    </div>
                                </div>`
                    },name:'perm'}
                ]
            });
        });

        
    </script>
    
@endsection