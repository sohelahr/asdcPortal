@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Feedback Lines
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{url('/feedback')}}">Feedbacks</a></li>
            <li class="breadcrumb-item active" aria-current="page">Feedback Lines</li>
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
                    <button class="btn bg-white" type="button" >
                        Course : {{$course}}
                    </button>
                </div>
                <div>
                    <button class="btn bg-white" type="button" >
                        Batch : {{$coursebatch}}
                    </button>
                </div>
                <div>
                    <button class="btn bg-white" type="button" >
                        Instructor : {{$instructor}}
                    </button>
                </div>
                <div>
                    <button class="btn bg-white" type="button" >
                        Start Date : {{$feedback_header->start_date}}
                    </button>
                </div>
                
                <div>
                    <button class="btn bg-white" type="button" >
                        End Date : {{$feedback_header->end_date}}
                    </button>
                </div>
                <div>
                    <button class="btn bg-white" type="button" >
                        Status : {{($feedback_header->status == '0' ? 'Initialized' : ($feedback_header->status == '1' ? 'Active' : 'Expired')) }}
                    </button>
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
                <table class="table table-hover" id="feedback_lines_table">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>View</th>
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
        baseurl = '{{url("/")}}';
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
        $('#feedback_lines_table').DataTable({
            processing: true,
            serverSide: true,
            searching:false,
            "pageLength": 30,
            "bDestroy": true,
            ajax: {
                "url":`{{url("feedback/get-all-feedback-lines/$feedback_header->id")}}`,
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            /* "columnDefs": [
                {"className": "text-center", "targets": '_all'}
            ], */
            columns: [
                {
                    data:'student_name',
                    name:'student_name'
                },
                {
                   data:'id',
                    render:function(data,type,row){
                        return '<a href="'+baseurl+'/feedback/lines/view/'+data+'"><span class="badge badge-success badge-pill">View</span></a>';
                    },
                    name:'id' 
                }
            ]
        });
    }

    </script>
@endsection