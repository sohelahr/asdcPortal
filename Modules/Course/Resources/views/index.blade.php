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
        
        <div class="card-body">
            <div class="float-right my-2">
                <button class="btn btn-success btn-icon-text" type="button" data-toggle="modal" data-target="#course-create">
                    Create
                    <i class="fa fa-plus btn-icon-prepend"></i>
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
                <form method="POST" action="{{url('course/create')}}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="course-create-title">Create Course</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" class="form-control form-control-sm" type="text" name="name" placeholder="eg: Digital Marketing">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="Duration">Duration</label>
                                <input id="Duration" class="form-control form-control-sm" type="text" name="duration" placeholder="eg : 3 months">
                            </div>
                            <div class="form-group col-6">
                                <label for="slug">Slug</label>
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

    <div id="course-edit" class="modal" tabindex="-1" role="dialog" aria-labelledby="course-edit-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST"  id="edit-form" action="{{url('course/edit/')}}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="course-edit-title">Edit Course</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-danger" id="showtext">Please Wait...</h5>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="edit-name" class="form-control form-control-sm" type="text" name="name" placeholder="eg: Digital Marketing">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="Duration">Duration</label>
                                <input id="edit-Duration" class="form-control form-control-sm" type="text" name="duration" placeholder="eg : 3 months">
                            </div>
                            <div class="form-group col-6">
                                <label for="slug">Slug</label>
                                <input id="edit-slug" class="form-control form-control-sm" type="text" name="slug" placeholder="eg : DM">
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
        
        
        function EditCourse(course_id){
            console.log(course_id)
            getEditData(course_id);
            $("#course-edit").modal('show');
        }

        function getEditData(course_id){
            $.ajax({
                type: "get",
                url: `{{url('course/edit/${course_id}')}}`,
                beforeSend: function () {
                    $('#showtext').show();
                },
                success: function (response) {
                    data = JSON.parse(response);

                    $("#edit-form").attr("action", `{{url('course/edit/${course_id}')}}`);
                    $("#edit-name").val(data.name);
                    $("#edit-Duration").val(data.Duration);
                    $("#edit-slug").val(data.slug);
                },
                complete: function () {
                    $('#showtext').hide();
                },
            });
        }
        
    </script>
    
@endsection