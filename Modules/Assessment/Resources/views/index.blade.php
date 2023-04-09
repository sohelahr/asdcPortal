@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Assessments</h3>
		@endslot
            <li class="breadcrumb-item active" aria-current="page">Assessments</li>
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
                        <div class="d-flex justify-content-between p-1 m-0 border header-buttons">
                            <div>
                                <a href="{{route('assessment_header_create')}}">
                                    <button class="btn bg-white" type="button" >
                                        <i class="fa fa-plus btn-icon-prepend"></i>
                                        Create Assessment
                                    </button>
                                </a>
                            </div>
                            <div>
                                <a href="{{route('assessment_header_create_language')}}">
                                    <button class="btn bg-white" type="button" >
                                        <i class="fa fa-plus btn-icon-prepend"></i>
                                        Language Assessment For other Courses
                                    </button>
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-4">
                                <select class="form-control" id="change_admission_by_batch">
                                    <option class="">Select Course</option>
                                    @foreach ($courses as $course)
                                        <option value="{{$course->id}}">{{$course->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <select class="form-control" id="course_batch">
                                    <option value="">Select Batch</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <select class="form-control" id="course_slot">
                                   <option value="">Select Timing</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary" id="get-assessment-btn"><i class="fa fa-search"></i></button>
                                <button class="btn btn-danger" id="reset-assessment-btn"><i class="icofont icofont-close"></i></button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="display datatables" id="assessment_header_table">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>Name</th>
                                        <th>Course</th>
                                        <th>Batch</th>
                                        <th>Timing</th>
                                        <th>Instructor</th>
                                        <th>Held on</th>
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
@endsection
@section('jcontent')
    <script>
        var all_url =  `{{url('assessment/get-all-assessment-headers/0/0/0')}}`;
        getAssessmentHeaders(all_url);
        
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
        function deleteAssessmentConfirm(id){
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

        function viewAssessment(id){
            let route = `{{url('assessment/show-assessment-header/${id}')}}`
            window.location.href = route;
        }

        $('.date_picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'dd-mm-yyyy',
            useCurrent: false,
            autoClose:true,
        });

        @if(\Illuminate\ Support\ Facades\ Session::has('created'))
        Notify('Created','Assessment Header was successfully created','success')
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            Notify('Updated','Assessment Header Was Successfully Update','info')
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            Notify('Deleted','Assessment Header Was Successfully Deleted','warning')
        @elseif(\Illuminate\Support\Facades\Session::has('prohibited'))
            Notify('Cannot Delete','This Assessment already has submissions','warning')
        @elseif(\Illuminate\ Support\ Facades\ Session::has('error'))
            Notify('Danger','Something Went Wrong ','danger')
        @endif


        $('#change_admission_by_batch').on('change',function(){
            let id = $('#change_admission_by_batch').val();
            $.ajax({
                type: "get",
                url: `{{url('attendance/getforminputs/${id}')}}`,
                beforeSend: function (){
                    $('#admissions-by-batches-loader').removeClass('d-none');
                },
                success: function (response) {
                    
                    $("#course_slot").empty();
                    $("#course_batch").empty();

                    if(response.course_slots.length > 0){
                        $("#course_slot").append(`
                            <option value="">Select Timing</option>
                        `);
                        $.each(response.course_slots, function (index, element) { 
                            $("#course_slot").append(`
                                <option value="${element.id}">${element.name}</option>
                            `);
                        });
                    }
                    else
                    {
                        $("#course_slot").append(`
                                <option value="">Not Found</option>
                            `);
                    }
                    
                    if(response.course_batches.length > 0){
                        $("#course_batch").append(`
                            <option value="">Select Batch</option>
                        `);
                        $.each(response.course_batches, function (index, element) { 
                            
                            $("#course_batch").append(`
                                <option value="${element.id}">${element.batch_number}</option>
                            `);
                        });
                    }
                    else
                    {
                        $("#course_batch").append(`
                                <option value="">Not Found</option>
                            `);
                    }
                    
                },
                complete: function(){
                    $('#admissions-by-batches-loader').addClass('d-none');
                }
            });
        });

        $('#get-assessment-btn').on('click',function(){
            let courseid = $('#change_admission_by_batch').val();
            let slotid = $('#course_slot').val();
            let batchid = $('#course_batch').val();
            if(slotid == "" || batchid == ""){
                return null;
            }
            console.log("hello")
            var url = `{{url('assessment/get-all-assessment-headers/${courseid}/${batchid}/${slotid}')}}`;
            getAssessmentHeaders(url);
        });

        $('#reset-assessment-btn').on('click',function(){
            $('#change_admission_by_batch').prop('selectedIndex',0);
            $('#course_slot').prop('selectedIndex',0);
            $('#course_batch').prop('selectedIndex',0);
            getAssessmentHeaders(all_url);
        });

        function getAssessmentHeaders(url){
            
            let courseid = 0;
            $('#assessment_header_table').DataTable({
                processing: true,
                serverSide: true,
                searching:false,
                "pageLength": 50,
                "bDestroy": true,
                ajax: {
                    "url":url,
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                columns: [
                    {
                        data:'name',
                        name:'name'
                    },
                    {
                        data:'course',
                        name:'course'
                    },
                    {
                        data:'coursebatch',
                        name:'coursebatch'
                    },
                    {
                        data:'courseslot',
                        name:'courseslot'
                    },
                    {
                        data:'instructor',
                        name:'instructor'
                    },
                    {
                        data:'held_on',
                        name:'held_on'
                    },
                    {
                        data:'action',
                        render:function(data,type,row){
                            return `
                                <div>
                                    <div  class="d-flex p-0 m-0">
                                        <button class="form-btn form-btn-success ms-4 me-2" onclick="viewAssessment(${row.id})" >
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <div class="ml-2">
                                            <button type=submit class="form-btn form-btn-danger ms-2" onclick="deleteAssessmentConfirm(${row.id})" >
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>        
                                        <form action='assessment/delete/${row.id}' id='delete_form_${row.id}' method="post" class="d-none">
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

        // $('#edit-form').validate({
        //         errorClass: "text-danger pt-1",            
                
        //         rules: {  
        //             end_date: {
        //                 required: true,
        //             },
        //         },

        //         messages: {
        //             end_date:{ 
        //                 required: "Please enter batch end date",
        //             },
        //         } 

        //     });
    </script>
@endsection