@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Batches</h3>
		@endslot
            <li class="breadcrumb-item active" aria-current="page">Course Batches</li>
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
                        @if(\App\Http\Helpers\CheckPermission::hasPermission('create.coursebatch'))
                        <div class="d-flex p-1 m-0 border header-buttons">
                            <div>
                                    <button class="btn bg-white" type="button" data-bs-toggle="modal" data-bs-target="#course-create">
                                        <i class="fa fa-plus btn-icon-prepend"></i>
                                        Create
                                    </button>
                            </div>
                        </div>
                        @endif
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table class="display datables" id="coursebatchtable">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>Sr no</th>
                                        <th>Course</th>
                                        <th>Batch Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
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
                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label for="batch_number">Batch Number <sup class="text-danger">*</sup></label>
                                            <input id="batch_number" class="form-control form-control-sm" type="text" name="batch_number" placeholder="eg : ">
                                        </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Batch Start Date <sup class="text-danger">*</sup></label>
                                                    <input class="date_picker form-control" type="text" data-language="en" name="start_date" readonly
                                                    />

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Batch End Date <sup class="text-danger">*</sup></label>
                                                    <input class="date_picker form-control" type="text" data-language="en" name="end_date" readonly
                                                    />

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

                <div id="coursebatch-edit" class="modal" tabindex="-1" role="dialog" 
                    data-backdrop="static" data-keyboard="false" aria-labelledby="course-edit-title" aria-hidden="true">
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
                                    <div class="row">
                                        <div class="col-12">
                                                <p>Please select the dates again while editing them</p>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Batch Start Date <sup class="text-danger">*</sup></label>
                                                    <input id="edit-start-date" class="date_picker form-control" type="text" data-language="en" name="start_date" readonly
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Batch End Date <sup class="text-danger">*</sup></label>
                                                    <input id="edit-end-date" class="date_picker form-control" type="text" data-language="en" name="end_date" readonly
                                                    />
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
        
        $('.date_picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'dd-mm-yyyy',
            useCurrent: false,
            autoClose:true,
        });
        @if(\Illuminate\Support\Facades\Session::has('created'))    
            Notify('Created','Course Batch Was Successfully Created','success')
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            Notify('Updated','Course Batch Was Successfully Update','info')
        @elseif(\Illuminate\Support\Facades\Session::has('already'))
            Notify('Warning','Course Batch already Present','warning')
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            Notify('Deleted','Course Batch Was Successfully Deleted','warning')
        @elseif(\Illuminate\Support\Facades\Session::has('error'))
            Notify('Danger','Something Went Wrong','danger')  
        @elseif(\Illuminate\Support\Facades\Session::has('prohibited'))
            Notify('Cannot Delete','This coursebatch already has admissions','warning')
        @elseif(\Illuminate\Support\Facades\Session::has('status'))
            Notify('Success','Status changed successfully')
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
                columnDefs: [{
                "defaultContent": "-",
                orderable:false,
                "targets": "_all"
                },
                {
                    className: 'text-center',
                    'targets':[5,6]
                }],
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
                                                    `<button class="form-btn form-btn-success"  title="Change Status to Inactive"
                                                    type="submit">Active / Current</button>`
                                                    :
                                                    `<button class="form-btn form-btn-success"  title="Change Status to Inactive"
                                                    type="submit">Active</button>`
                                                }`
                                                :
                                            `<button class="form-btn form-btn-warning" type="submit"  title="Change Status to Active" >Inactive</button>`
                                        }
                                    </form>`
                    },name:'status'},
                    {data: 'action',render:function(data,type,row){
                        return `<div>
                                    <div  class="d-flex p-0 m-0">
                                        ${data.edit_perm ? 
                                        `<button class="form-btn form-btn-warning ms-4 me-2" onclick="EditCourseBatch(${row.id})">
                                            <i class="fa fa-pencil"></i>
                                        </button>` 
                                        : null}
                                        ${data.delete_perm ? 
                                        
                                        `<div class="ml-2">
                                                    <button type=submit class="form-btn form-btn-danger ms-2" onclick="deleteBatchConfirm(${row.id})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                            </div>        
                                                <form action='coursebatch/delete/${row.id}' id='delete_form_${row.id}' method="post" class="d-none">
                                                    @csrf
                                                </form>
                                        `: null}
                                    </div>
                                </div>`
                    },name:'action'}
                ]
            });


            $('#coursebatch-create').validate({
                errorClass: "text-danger pt-1",
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "start_date" ) {
                        error.insertAfter(element.parent());
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