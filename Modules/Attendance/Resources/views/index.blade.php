@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Attendance</h3>
		@endslot
            <li class="breadcrumb-item active" aria-current="page">Attendance</li>
	@endcomponent
    <div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
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
                                <a href="{{route('attendance_import')}}">
                                    <button class="btn bg-white" type="button" data-toggle="modal" data-target="#employed-modal">
                                        <i class="fa fa-plus btn-icon-prepend"></i>
                                        Import New
                                    </button>
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="row mb-3">
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
                            <div class="col-4">
                                <select class="form-control" id="course_slot">
                                    @foreach ($firstslots as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="display datatables" id="attendance_table">
                                <thead class="bg-primary">
                                    <tr>
                                        <tr>
                                            <th>Roll no</th>
                                            <th>Name</th>
                                            <th>Absent</th>
                                            <th>Present</th>
                                            <th>Weekly Off</th>
                                            <th>Holiday</th>
                                            <th>Total days</th>
                                            <th>Attendance</th>
                                        </tr>
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
        getAttendanceRecords();
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
        @if(\Illuminate\ Support\ Facades\ Session::has('published'))
            Notify('Publish','Attendance was successfully published','success')
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
                    
                    /* 
                    generateDoughnutChartForBatchAdmissions(piedata); */
                },
                complete: function(){
                    $('#admissions-by-batches-loader').addClass('d-none');
                }
            });
        });

        $('#course_slot').on('change',function(){
            getAttendanceRecords();
        });

    function getAttendanceRecords(){
        
        let courseid = $('#change_admission_by_batch').val();
        let courseslotid = $('#course_slot').val();
        let coursebatchid = $('#course_batch').val();
        if(courseslotid == "" || coursebatchid == ""){
            return null;
        }
        $('#attendance_table').DataTable({
            processing: true,
            serverSide: true,
            searching:false,
            orderable:false,
            "pageLength": 50,
            "bDestroy": true,
            ajax: {
                "url":`{{url("attendance/get-all-attendance/".'${courseid}'."/".'${courseslotid}'."/".'${coursebatchid}')}}`,
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columnDefs": [
                {"className": "text-center", "targets": '_all'}
            ],
            columns: [{
                    data: 'roll_no',
                    name: "roll_no"
                },
                {
                    data: 'student_name',
                    render:function(data,type,row){
                        return "<a href='userprofile/admin/"+row.student_id+"/viewfromother'>"+data+"</a>"
                    },
                    name: "roll_no"
                },
                {
                    data: 'absent',
                    name: 'absent'
                },
                {
                    data: 'present',
                    name: 'present'
                },
                {
                    data: 'weekly_off',
                    name: 'weekly_off'
                },
                {
                    data: 'holiday',
                    name: 'holiday'
                },
                {
                    data: 'total',
                    name: 'total'
                },{
                    data: 'attendance',
                    name: 'attendance'
                },
            ]
        });
    }

    </script>
@endsection