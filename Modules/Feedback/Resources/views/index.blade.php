@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Feedback
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Feedback</li>
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
                    <a href="{{route('feedback_header_create')}}">
                        <button class="btn bg-white" type="button" >
                            <i class="fas fa-user-plus btn-icon-prepend"></i>
                            Initialize New
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
                <table class="table table-hover" id="feedback_header_table">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Batch</th>
                            <th>Instructor</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
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
        getFeedbackHeaders();
        @if(\Illuminate\ Support\ Facades\ Session::has('created'))
            $.toast({
                heading: 'Publish',
                text: 'Feedback Form was successfully created',
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

    function getFeedbackHeaders(){
        
        let courseid = 0;
        $('#feedback_header_table').DataTable({
            processing: true,
            serverSide: true,
            searching:false,
            "pageLength": 30,
            "bDestroy": true,
            ajax: {
                "url":`{{url("feedback/get-all-feedback-headers/".'${courseid}')}}`,
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            /* "columnDefs": [
                {"className": "text-center", "targets": '_all'}
            ], */
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
            ]
        });
    }

    </script>
@endsection