@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Feedbacks</h3>
		@endslot
            <li class="breadcrumb-item active" aria-current="page">Feedbacks</li>
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
                    <div id="admissions-by-batches-loader" class="d-none">
                        <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                            <div> 
                                <div class="loader-box">
                                    <div class="loader-7"></div>
                                </div>              
                            </div>   
                        </div>
                    </div>
                    @if(\App\Http\Helpers\CheckPermission::hasPermission('create.profiles'))
                        <div class="d-flex p-1 m-0 border header-buttons">
                            <div>
                                <a href="{{route('feedback_header_create')}}">
                                    <button class="btn bg-white" type="button" >
                                        <i class="fa fa-plus btn-icon-prepend"></i>
                                        Create Feedback
                                    </button>
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        {{-- <div class="row mb-3">
                            <div class="col-4">
                                <select class="form-control" id="change_admission_by_batch">
                                    @foreach ($courses as $course)
                                        <option value="{{$course->id}}">{{$course->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <select class="form-control" id="course_batch">
                                    @foreach ($firstbatches as $item)
                                        <option value="{{$item->id}}">{{$item->batch_identifier}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="table-responsive">
                            <table class="display datatables" id="feedback_header_table">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>Course</th>
                                        <th>Batch</th>
                                        <th>Instructor</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Feedbacks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="feedback-edit" class="modal" tabindex="-1" role="dialog" 
        data-backdrop="static" data-keyboard="false" aria-labelledby="course-edit-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST"  id="edit-form" action="{{url('feedback/edit/')}}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="course-create-title">Edit Header</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <div class="form-group">
                                    <label class="form-label">Old End Date <sup class="text-danger">*</sup></label>
                                    <input id="edit-false-end-date" class="form-control" type="text" data-language="en" name="end_dummy_date" readonly
                                    />
                                </div> 
                                <div class="form-group">
                                    <label class="form-label">New End Date <sup class="text-danger">*</sup></label>
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
@endsection
@section('jcontent')
    <script>
        getFeedbackHeaders();
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
            $('#feedback-edit').modal('hide');
        }
        function deleteFeedbackConfirm(id){
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

        @if(\Illuminate\ Support\ Facades\ Session::has('created'))
        Notify('Publish','Feedback Form was successfully created','success')
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            Notify('Updated','Feedback Header Was Successfully Update','info')
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            Notify('Deleted','Feedback Header Was Successfully Deleted','warning')
        @elseif(\Illuminate\Support\Facades\Session::has('prohibited'))
            Notify('Cannot Delete','This Feedback already has submissions','warning')
        @elseif(\Illuminate\ Support\ Facades\ Session::has('error'))
            Notify('Danger','Something Went Wrong ','danger')
        @endif

        function EditFeedbackHeader(coursebatch_id){
            getEditData(coursebatch_id);
        }

        function getEditData(coursebatch_id){
            $.ajax({
                type: "get",
                url: `{{url('feedback/edit/${coursebatch_id}')}}`,
                beforeSend: function () {
                    $('#overlay-loader').removeClass('d-none');
                    $('#overlay-loader').show();
                },
                success: function (response) {
                    data = JSON.parse(response);
                    $("#edit-form").attr("action", `{{url('feedback/edit/${coursebatch_id}')}}`);
                    $("#edit-false-end-date").val(data.end_date);
                    $("#edit-end-date").val('');
                    $("#feedback-edit").modal('show');
                },
                complete: function () {
                    $('#overlay-loader').hide();
                },
            });
        }

        function getFeedbackHeaders(){
            
            let courseid = 0;
            $('#feedback_header_table').DataTable({
                processing: true,
                serverSide: true,
                searching:false,
                "pageLength": 50,
                "bDestroy": true,
                ajax: {
                    "url":`{{url("feedback/get-all-feedback-headers/".'${courseid}')}}`,
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                "columnDefs": [
                    {"className": "text-center", "targets": [6,7]}
                ],
                columns: [
                    {
                        data:'course',
                        name:'course'
                    },
                    {
                        data:'coursebatch',
                        name:'coursebatch'
                    },
                    {
                        data:'instructor',
                        name:'instructor'
                    },
                    {
                        data:'start_date',
                        name:'start_date'
                    },
                    {
                        data:'end_date',
                        name:'end_date'
                    },
                    {
                        data:'status',
                        render:function(data,type,row){
                            if(data == '1'){
                                return "<span>Active</span>"
                            }
                            else if(data == '2'){
                                return "<span>Expired</span>"
                            }
                            else{
                                return "<span>Initialized</span>"
                            }
                        },
                        name:'status'
                    },
                    {
                    data:'id',
                        render:function(data,type,row){
                            return '<a href="feedback/lines/'+data+'"><span class="txt-primary">View</span></a>';
                        },
                        name:'id',orderable:false 
                    },
                    {
                        data:'action',
                        render:function(data,type,row){
                            return `
                                <div>
                                    <div  class="d-flex p-0 m-0">
                                        <button class="form-btn form-btn-warning ms-4 me-2" onclick="EditFeedbackHeader(${row.id})" >
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <div class="ml-2">
                                            <button type=submit class="form-btn form-btn-danger ms-2" onclick="deleteFeedbackConfirm(${row.id})" >
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>        
                                        <form action='feedback/delete/${row.id}' id='delete_form_${row.id}' method="post" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                                `;
                        },
                        name:'id',orderable:false
                    }
                ]
            });

            
        }

        $('#edit-form').validate({
                errorClass: "text-danger pt-1",            
                
                rules: {  
                    end_date: {
                        required: true,
                    },
                },

                messages: {
                    end_date:{ 
                        required: "Please enter batch end date",
                    },
                } 

            });
    </script>
@endsection