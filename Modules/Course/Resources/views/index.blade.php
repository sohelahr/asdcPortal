@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Courses
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Courses</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div id="overlay-loader" class="d-none">
            <div style="height: 100%;width:100%;background:rgba(121, 121, 121, 0.11);position: absolute;z-index:999;" class="d-flex justify-content-center align-items-center"> 
                <div >  
                    
                        <div class="dot-opacity-loader">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="float-right my-2">
                <button class="btn btn-outline-primary btn-fw" type="button" data-toggle="modal" data-target="#course-create">
                     + Create
                </button>
            </div>    
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Duration</th>
                            <th>Slug</th>
                            <th>Timings</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td>
                                    {{$course->name}}
                                </td>
                                <td>{{$course->Duration}}</td>
                                <td>{{$course->slug}}</td>        
                                <td><a class="nav-link p-0" href="{{route('courseslot',$course->id)}}">View</a></td>
                                <td class="d-flex p-1">
                                        <button class="btn btn-dark btn-rounded p-2 mr-2" onclick="EditCourse({{$course->id}})">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    <form action="{{url('course/delete/'.$course->id)}}" method="post" class="ml-2">
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

    <div id="course-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="course-create-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{url('course/create')}}" id  ="courses">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="course-create-title">Create Course</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name <sup class="text-danger">*</sup></label>
                            <input id="name" class="form-control form-control-sm" type="text" name="name" placeholder="eg: Digital Marketing">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="Duration">Duration <sup class="text-danger">*</sup></label>
                                <input id="Duration" class="form-control form-control-sm" type="text" name="duration" placeholder="eg : 3 months">
                            </div>
                            <div class="form-group col-6">
                                <label for="slug">Slug <sup class="text-danger">*</sup></label>
                                <input id="slug" class="form-control form-control-sm" type="text" name="slug" placeholder="eg : DM">
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
                        <div class="form-row">
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

    
@endsection
@section('jcontent')
    <script>

        function closeModal(){
            $('#course-edit').modal('hide');
        }

        @if(\Illuminate\Support\Facades\Session::has('created'))    
            $.toast({
                heading: 'Created',
                text: 'Course Was Successfully Created',
                position:'top-right',
                icon: 'success',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            $.toast({
                heading: 'Updated',
                text: 'Course Was Successfully Updated',
                position:'top-right',
                icon: 'info',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            $.toast({
                heading: 'Deleted',
                text: 'Course Was Successfully Deleted',
                position:'top-right',
                icon: 'warning',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('prohibited'))
            $.toast({
                heading: 'Cannot Delete',
                text: 'This course already has registrations or admissions',
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
        function EditCourse(course_id){
            console.log(course_id)
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
        $('#courses').validate({
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
                        required: "Please enter your name",
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
                        required: "Please enter your name",
                    },

                    duration:{
                        required: "Please enter duration",
                    },

                    slug:{ 
                        required: "Please enter a slug",
                    },

                } 

        });
    });

        
    </script>
    
@endsection