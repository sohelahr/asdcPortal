@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Attendance
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Attendance</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div id="admissions-by-batches-loader" class="d-none">
            <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                <div class="bar-loader">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>    
            </div>
        </div>
        @if(\App\Http\Helpers\CheckPermission::hasPermission('create.profiles'))
            <div class="d-flex p-1 m-0 border header-buttons">
                <div>
                    <a href="{{route('attendance_import')}}">
                        <button class="btn bg-white" type="button" data-toggle="modal" data-target="#employed-modal">
                            <i class="fas fa-user-plus btn-icon-prepend"></i>
                            Import New Attendance Sheet
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
                <table class="table table-hover" id="attendance_table">
                    <thead>
                        <tr>
                            <tr>
                                <th>Roll no</th>
                                <th>Name</th>
                                <th>Present</th>
                                <th>Absent</th>
                                <th>Total days</th>
                                <th>Attendance</th>
                            </tr>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection
@section('jcontent')
    <script>
        getAttendanceRecords();
        @if(\Illuminate\ Support\ Facades\ Session::has('published'))
            $.toast({
                heading: 'Publish',
                text: 'Attendance was successfully published',
                position: 'top-right',
                icon: 'success',
                loader: true, // Change it to false to disable loader
                loaderBg: '#9EC600' // To change the background
            })

        @elseif(\Illuminate\ Support\ Facades\ Session::has('error'))
            $.toast({
                heading: 'Danger',
                text: 'Something Went Wrong ',
                position: 'top-right',
                icon: 'danger',
                loader: true, // Change it to false to disable loader
                loaderBg: '#9EC600' // To change the background
            })
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
            "pageLength": 30,
            "bDestroy": true,
            ajax: {
                "url":`{{url("attendance/get-all-attendance/".'${courseid}'."/".'${courseslotid}'."/".'${coursebatchid}')}}`,
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columnDefs": [
                {"className": "text-center", "targets": [1,2]}
            ],
            columns: [{
                    data: 'date',
                    name: "date"
                },
                {
                    data: 'status',
                    render: function (type, data, row) {
                        if (row.status == "0")
                            return "<label class='text-danger'>Absent</label>"
                        else if (row.status == "1")
                            return "<label class='text-warning'>No punch out</label>"
                        else if (row.status == "2")
                            return "<label class='text-success'>Present</label>"
                        else if (row.status == "3")
                            return "<label class='text-info'>Week Off</label>"
                        else if (row.status == "4")
                            return "<label class='text-primary'>Holiday</label>"
                    },
                    name: 'status'
                },
                {
                    data: 'punch_records',
                    name: 'punch_records'
                },
            ]
        });
    }

    </script>
@endsection