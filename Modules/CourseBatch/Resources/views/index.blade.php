@extends('layouts.admin.app')

@section('content')
<div class="page-header">
        <h3 class="page-title">
            Course Batches
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Course Batches</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        
            @if(\App\Http\Helpers\CheckPermission::hasPermission('create.coursebatch'))
            <div class="d-flex p-1 m-0 border header-buttons">
                <div>
                        <button class="btn bg-white" type="button" data-toggle="modal" data-target="#course-create">
                            <i class="fas fa-plus btn-icon-prepend"></i>
                            Create
                        </button>
                </div>
            </div>
            @endif
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
            
            <div class="table-responsive">
                <table class="table table-striped" id="coursebatchtable">
                    <thead>
                        <tr>
                            <th style="width: 30px">Sr no</th>
                            <th>Course</th>
                            <th>Batch Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th style="max-width: 150px">Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="course-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="course-create-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{url('coursebatch/create')}}" id="coursebatch-create">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="course-create-title">Create Course Batch</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="course">Course <sup class="text-danger">*</sup></label>
                            <select id="course" class="form-control" name="course_id">
                                @foreach ($courses as $course)
                                    <option value="{{$course->id}}">{{$course->name}}</option>                                    
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="batch_number">Batch Number <sup class="text-danger">*</sup></label>
                                <input id="batch_number" class="form-control form-control-sm" type="text" name="batch_number" placeholder="eg : ">
                            </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Batch Start Date <sup class="text-danger">*</sup></label>
                                        <div id="datepicker-popup" class="input-group date datepicker p-0 m-0">
                                            <input required type="text" class="form-control form-control-sm" name="start_date">
                                            <span class="input-group-addon input-group-append border-left">
                                                <i class="far fa-calendar input-group-text py-1 px-2"></i>
                                            </span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Batch End Date <sup class="text-danger">*</sup></label>
                                        <div id="datepicker-popup" class="input-group date datepicker p-0 m-0">
                                            <input required type="text" class="form-control form-control-sm" name="end_date">
                                            <span class="input-group-addon input-group-append border-left">
                                                <i class="far fa-calendar input-group-text py-1 px-2"></i>
                                            </span>
                                        </div>

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

    <div id="coursebatch-edit" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="course-edit-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST"  id="edit-form" action="{{url('coursebatch/edit/')}}">
                    @csrf
                    <div class="modal-header">

                        <h5 class="modal-title" id="course-create-title">Edit Course Batch</h5>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="course">Course <sup class="text-danger">*</sup></label>
                            <select id="edit-course" class="form-control" name="course_id">
                                @foreach ($courses as $course)
                                    <option value="{{$course->id}}" id="edit-option-{{$course->id}}"> {{$course->name}}</option>                                    
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="batch_number">Batch Number <sup class="text-danger">*</sup></label>
                                <input id="edit-batch_number" class="form-control form-control-sm" type="text" name="batch_number" placeholder="eg : ">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                    <p>Please select the dates again while editing them</p>
                            </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Batch Start Date <sup class="text-danger">*</sup></label>
                                        <div id="datepicker-popup" class="input-group date datepicker p-0 m-0">
                                            <input required type="text" class="form-control form-control-sm" name="start_date" id="edit-start-date">
                                            <span class="input-group-addon input-group-append border-left">
                                                <i class="far fa-calendar input-group-text py-1 px-2"></i>
                                            </span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Batch End Date <sup class="text-danger">*</sup></label>
                                        <div id="end-datepicker-popup" class="input-group date datepicker p-0 m-0">
                                            <input required type="text" class="form-control form-control-sm" name="end_date" id="edit-end-date">
                                            <span class="input-group-addon input-group-append border-left">
                                                <i class="far fa-calendar input-group-text py-1 px-2"></i>
                                            </span>
                                        </div>

                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Submit" class="btn btn-primary">
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
            $('#coursebatch-edit').modal('hide');
        }
        function deleteBatchConfirm(id){
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
        
        $('.datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            useCurrent: false,
        });
        @if(\Illuminate\Support\Facades\Session::has('created'))    
            $.toast({
                heading: 'Created',
                text: 'Course Batch Was Successfully Created',
                position:'top-right',
                icon: 'success',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            $.toast({
                heading: 'Updated',
                text: 'Course Batch Was Successfully Updated',
                position:'top-right',
                icon: 'info',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('already'))
            $.toast({
                heading: 'Warning',
                text: 'Course Batch already Present',
                position:'top-right',
                icon: 'warning',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            $.toast({
                heading: 'Deleted',
                text: 'Course Batch Was Successfully Deleted',
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
        @elseif(\Illuminate\Support\Facades\Session::has('prohibited'))
        $.toast({
            heading: 'Cannot Delete',
            text: 'This coursebatch already has admissions',
            position:'top-right',
            icon: 'warning',
            loader: true,        // Change it to false to disable loader
            loaderBg: '#9EC600'  // To change the background
        })
        @elseif(\Illuminate\Support\Facades\Session::has('status'))
            $.toast({
                heading: 'Success',
                text: 'Status changed Succesfully ',
                position:'top-right',
                icon: 'danger',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @endif
        function EditCourseBatch(coursebatch_id){
            getEditData(coursebatch_id);
        }

        function getEditData(coursebatch_id){
            $.ajax({
                type: "get",
                url: `{{url('coursebatch/edit/${coursebatch_id}')}}`,
                beforeSend: function () {
                    $('#overlay-loader').removeClass('d-none');
                    $('#overlay-loader').show();
                },
                success: function (response) {
                    data = JSON.parse(response);

                    $("#edit-form").attr("action", `{{url('coursebatch/edit/${coursebatch_id}')}}`);
                    $("#edit-batch_number").val(data.batch_number);
                    $("#edit-start-date").val(data.start_date);
                    $("#edit-end-date").val(data.expiry_date);
                    $("#edit-course option").map((index,option) => {
                        $("#"+option.id).removeAttr("selected");
                        if(option.value == data.course_id){
                            $("#"+option.id).attr("selected","")
                        }

                    })
                    $("#coursebatch-edit").modal('show');
                },
                complete: function () {
                    $('#overlay-loader').hide();
                },
            });
        }

        $(document).ready(function (){
            $('#coursebatchtable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('course_batch_data')}}",
                columns:[
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'course_name',name:"course_name"},
                    {data: 'batch_number',name:"batch_number"},
                    {data: 'start_date',name:"start_date"},
                    {data: 'expiry_date',name:"expiry_date"},
                    {data:'status',render:function(data,type,row){
                        return ` <form action="coursebatch/changestatus/${row.id}" method="get">
                                        @csrf
                                        ${row.status == 1 ? 
                                                `${row.is_current ? 
                                                    `<input class="btn btn-sm btn-success badge-pill status_btns" 
                                                    type="submit" value="Active / Current">`
                                                    :
                                                    `<input class="btn btn-sm btn-success badge-pill status_btns" 
                                                    type="submit" value="Active">`
                                                }`
                                                :
                                            `<input class="btn btn-sm badge-pill btn-warning status_btns" type="submit" value="Inactive"></input>`
                                        }
                                    </form>`
                    },name:'status'},
                    {data: 'action',render:function(data,type,row){
                        return ` <div  class="d-flex p-0 m-0">
                                        ${data.edit_perm ? 
                                        `<button class="btn btn-dark btn-rounded p-2 mr-2 my-0" onclick="EditCourseBatch(${row.id})">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>` 
                                        : null}
                                        ${data.delete_perm ? 
                                        
                                        `<div class="ml-2">
                                                    <button type=submit class="btn btn-danger btn-rounded p-2" onclick="deleteBatchConfirm(${row.id})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                            </div>        
                                                <form action='coursebatch/delete/${row.id}' id='delete_form_${row.id}' method="post" class="d-none">
                                                    @csrf
                                                </form>
                                        `: null}
                                        </div>`
                    },name:'action'}
                ]
            });


            $('#coursebatch-create').validate({
                errorClass: "text-danger pt-1",
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "start_date" ) {
                        error.insertAfter($("#datepicker-popup"));
                    }
                    else if (element.attr("name") == "end_date"){
                        error.insertAfter(element.parent());

                    }
                    else {
                        error.insertAfter(element);
                    }          
                },          
                rules: {     
                    course_id: {
                        required: true,
                    },
                    batch_number:{
                        required:true,
                    },
                    start_date: {
                        required: true,                    
                    required: true,                    
                        required: true,                    
                    },

                    end_date: {
                        required: true,
                    },

                },

                messages: {
                    course_id:{
                        required: "Please select course",
                    },
                    batch_number:{
                        required:"Enter Batch Number",
                    },
                    start_date:{
                        required: "Please enter batch start date",
                    },
                    end_date:{ 
                        required: "Please enter batch end date",
                    },

                } 
            });
            $('#edit-form').validate({
            errorClass: "text-danger pt-1",            
            errorPlacement: function(error, element) {
                if (element.attr("name") == "start_date" ) {
                    error.insertAfter($("#datepicker-popup"));
                }
                else if (element.attr("name") == "end_date")
                {
                    error.insertAfter(element.parent);
                }
                else {
                    error.insertAfter(element);
                }          
            },
            rules: {     
                course_id: {
                    required: true,
                },
                batch_number:{
                    required:true,
                },
                start_date: {
                    required: true,                    
                },

                end_date: {
                    required: true,
                },

            },

            messages: {
                course_id:{
                    required: "Please select course",
                },
                batch_number:{
                    required:"Enter Batch Number",
                },
                start_date:{
                    required: "Please enter batch start date",
                },

                end_date:{ 
                    required: "Please enter batch end date",
                },

            } 

        });
    });
    </script>
    
@endsection