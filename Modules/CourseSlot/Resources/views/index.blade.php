@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Timings For {{$course->name}} Course</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('/course')}}">Courses</a></li>
            <li class="breadcrumb-item active" aria-current="page">Timings</li>
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
        @if(\App\Http\Helpers\CheckPermission::hasPermission('create.coursesslots'))
            <div class="d-flex p-1 m-0 border header-buttons">
                <div>
                    <button class="btn bg-white" type="button" data-bs-toggle="modal" data-bs-target="#timing-create">
                        <i class="fa fa-plus btn-icon-prepend"></i>
                        Create
                    </button>
                </div>
            </div>    
        @endif
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="display datatables" id="timings">
                    <thead class="bg-primary">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Total Capacity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
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
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Timing in hours <sup class="text-danger">*</sup></label>
                            <input id="name" class="form-control" type="text" name="name" placeholder="eg: 10:00 - 12:00">
                        </div>
                        <input type="hidden" name="course_id" value="{{$course->id}}">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="Total Capacity">Total Capacity <sup class="text-danger">*</sup></label>
                                <input id="TotalCapacity" class="form-control" type="text" name="TotalCapacity" placeholder="eg : 60">
                            </div>
                            {{-- <div class="form-group col-6">
                                <label for="CurrentCapacity">Current Capacity <sup class="text-danger">*</sup></label>
                                <input id="CurrentCapacity" class="form-control" type="text" name="CurrentCapacity" placeholder="eg : 59">
                            </div> --}}
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
                        <input type="hidden" name="course_id" value="{{$course->id}}">

                        <div class="form-group">
                            <label for="name">Timing in hours<sup class="text-danger">*</sup></label>
                            <input id="edit-name" class="form-control" type="text" name="name" placeholder="eg: Digital Marketing">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="TotalCapacity">Total Capacity <sup class="text-danger">*</sup></label>
                                <input id="edit-TotalCapacity" class="form-control" type="text" name="TotalCapacity" placeholder="eg : 3 months">
                            </div>
                            {{-- <div class="form-group col-6">
                                <label for="CurrentCapacity">Current Capacity <sup class="text-danger">*</sup></label>
                                <input id="edit-CurrentCapacity" class="form-control form-control-sm" type="text" name="CurrentCapacity" placeholder="eg : DM">
                            </div> --}}
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
        var course_id = '{{$course->id}}';
        function closeModal(){
            $('#timing-edit').modal('hide');
        }
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
        function deleteTimingConfirm(id){
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
            Notify('Created','Course Timing Was Successfully Created','success')
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            Notify('Updated','Course Timing Was Successfully Updated','info')
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            Notify('Deleted','Course Timing Was Successfully Deleted','warning')
        @elseif(\Illuminate\Support\Facades\Session::has('error'))
            Notify('Danger','Something Went Wrong','danger')  
        @elseif(\Illuminate\Support\Facades\Session::has('prohibited'))
            Notify('Cannot Delete','This timing already has admissions','warning')
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
                    console.log(timing_id)
                    $("#edit-form").attr("action", `{{url('courseslot/edit/${timing_id}')}}`);
                    $("#edit-name").val(data.name);
                    $("#edit-TotalCapacity").val(data.TotalCapacity);/* 
                    $("#edit-CurrentCapacity").val(data.CurrentCapacity); */
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
                    /* CurrentCapacity: {
                        required: true,                    
                    }, */
                },

                messages: {
                    name:{
                        required: "Please Add Timing",
                    },
                    TotalCapacity:{
                        required:"Please Add Total Capacity",
                    },
                    /* CurrentCapacity:{
                        required: "Please Add Current Capacity",
                    }, */
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
                    /* CurrentCapacity: {
                        required: true,                    
                    }, */
                },

                messages: {
                    name:{
                        required: "Please Add Timing",
                    },
                    TotalCapacity:{
                        required:"Please Add Total Capacity",
                    },
                    /* CurrentCapacity:{
                        required: "Please Add Current Capacity",
                    }, */
                } 

            });

            $('#timings').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{url('courseslot/data/${course_id}')}}`,
                /* columnDefs: [{
                "defaultContent": "-",
                orderable:false,
                "targets": "_all"
                }], */
                columns:[
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name',name:"name"},
                    {data: 'TotalCapacity',name:"TotalCapacity"},
                    {data: 'perm',render:function(data,type,row){
                        return `<div>
                                    <div  class="d-flex p-0 m-0">
                                        ${data.edit_perm ? 
                                        `<button class="form-btn form-btn-warning ms-4 me-2" onclick="EditTiming(${row.id})">
                                            <i class="fa fa-pencil"></i>
                                        </button>` 
                                        : null}
                                        ${data.delete_perm ? 
                                        
                                        `<div class="ml-2">
                                                    <button type=submit class="form-btn form-btn-danger ms-2" onclick="deleteTimingConfirm(${row.id})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                            </div>        
                                                <form action='{{url('courseslot/delete/${row.id}')}}' id='delete_form_${row.id}' method="post" class="d-none">
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
