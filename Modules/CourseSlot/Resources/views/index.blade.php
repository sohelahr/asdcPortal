@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Timings For {{$course->name}} Course
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{url('/course')}}">Courses</a></li>
            <li class="breadcrumb-item active" aria-current="page">Timings</li>
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
                <button class="btn btn-outline-primary btn-fw" type="button" data-toggle="modal" data-target="#timing-create">
                   + Create
                </button>
            </div>    
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Total Capacity</th>
                            <th>Current Capacity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courseslot as $timing)
                            <tr>
                                <td>
                                    {{$timing->name}}
                                </td>
                                <td>{{$timing->TotalCapacity}}</td>
                                <td>{{$timing->CurrentCapacity}}</td>        
                                <td class="d-flex p-1">
                                        <button class="btn btn-dark btn-rounded p-2 mr-2" onclick="EditTiming({{$timing->id}})">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    <form action="{{url('courseslot/delete/'.$timing->id)}}" method="post" class="ml-2">
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

    <div id="timing-create" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="timing-create-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{url('courseslot/create')}}" id="timing-create-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="timing-create-title">Create timing for {{$course->name}}</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Timing in hours <sup class="text-danger">*</sup></label>
                            <input id="name" class="form-control form-control-sm" type="text" name="name" placeholder="eg: 10:00 - 12:00">
                        </div>
                        <input type="hidden" name="course_id" value="{{$course->id}}">
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="Total Capacity">Total Capacity <sup class="text-danger">*</sup></label>
                                <input id="TotalCapacity" class="form-control form-control-sm" type="text" name="TotalCapacity" placeholder="eg : 60">
                            </div>
                            <div class="form-group col-6">
                                <label for="CurrentCapacity">Current Capacity <sup class="text-danger">*</sup></label>
                                <input id="CurrentCapacity" class="form-control form-control-sm" type="text" name="CurrentCapacity" placeholder="eg : 59">
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

    <div id="timing-edit" class="modal" tabindex="-1" role="dialog" aria-labelledby="timing-edit-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST"  id="edit-form" action="{{url('courseslot/edit/')}}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="timing-edit-title">Edit timing</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Timing in hours <sup class="text-danger">*</sup></label>
                            <input id="edit-name" class="form-control form-control-sm" type="text" name="name" placeholder="eg: Digital Marketing">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="TotalCapacity">Total Capacity <sup class="text-danger">*</sup></label>
                                <input id="edit-TotalCapacity" class="form-control form-control-sm" type="text" name="TotalCapacity" placeholder="eg : 3 months">
                            </div>
                            <div class="form-group col-6">
                                <label for="CurrentCapacity">Current Capacity <sup class="text-danger">*</sup></label>
                                <input id="edit-CurrentCapacity" class="form-control form-control-sm" type="text" name="CurrentCapacity" placeholder="eg : DM">
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
            $('#timing-edit').modal('hide');
        }
        @if(\Illuminate\Support\Facades\Session::has('created'))    
            $.toast({
                heading: 'Created',
                text: 'CourseSlot Was Successfully Created',
                position:'top-right',
                icon: 'success',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            $.toast({
                heading: 'Updated',
                text: 'CourseSlot Was Successfully Updated',
                position:'top-right',
                icon: 'info',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            $.toast({
                heading: 'Deleted',
                text: 'CourseSlot Was Successfully Deleted',
                position:'top-right',
                icon: 'warning',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('prohibited'))
            $.toast({
                heading: 'Cannot Delete',
                text: 'This course Timing already has registrations or admissions',
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
        
        function EditTiming(timing_id){
            getEditData(timing_id);
        }

        function getEditData(timing_id){
            $.ajax({
                type: "get",
                url: `{{url('courseslot/edit/${timing_id}')}}`,
                beforeSend: function () {
                    $('#overlay-loader').removeClass('d-none');
                    $('#overlay-loader').show();
                    
                },
                success: function (response) {
                    data = JSON.parse(response);

                    $("#edit-form").attr("action", `{{url('courseslot/edit/${timing_id}')}}`);
                    $("#edit-name").val(data.name);
                    $("#edit-TotalCapacity").val(data.TotalCapacity);
                    $("#edit-CurrentCapacity").val(data.CurrentCapacity);
                    $("#timing-edit").modal('show');
                    
                },
                complete: function () {
                    $('#overlay-loader').hide();
                },
            });
        }
        $(document).ready(function () {
             $('#timing-create-form').validate({
                errorClass: "text-danger pt-1",            
                rules: {     
                    name: {
                        required: true,
                    },
                    TotalCapacity:{
                        required:true,
                    },
                    CurrentCapacity: {
                        required: true,                    
                    },
                },

                messages: {
                    name:{
                        required: "Please Add Timing",
                    },
                    TotalCapacity:{
                        required:"Please Add Total Capacity",
                    },
                    CurrentCapacity:{
                        required: "Please Add Current Capacity",
                    },
                } 

            });
             $('#edit-form').validate({
                errorClass: "text-danger pt-1",            
                rules: {     
                    name: {
                        required: true,
                    },
                    TotalCapacity:{
                        required:true,
                    },
                    CurrentCapacity: {
                        required: true,                    
                    },
                },

                messages: {
                    name:{
                        required: "Please Add Timing",
                    },
                    TotalCapacity:{
                        required:"Please Add Total Capacity",
                    },
                    CurrentCapacity:{
                        required: "Please Add Current Capacity",
                    },
                } 

            });
        });
    </script>
    
@endsection
