@extends('layouts.admin.app')
@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Feedback Lines</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('feedback')}}">Feedbacks</a></li>
            <li class="breadcrumb-item active" aria-current="page">Feedback Lines</li>
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
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
                        <div class="table-responsive">
                            <table class="display datatables" id="feedback_lines_table">
                                <thead class="bg-primary">
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
            </div>
        </div>
    </div>
@endsection
@section('jcontent')
    <script>
        baseurl = '{{url("/")}}';
        getFeedbackHeaders();


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
            "columnDefs": [
                {"className": "text-center", "targets": [1]}
            ],
            columns: [
                {
                    data:'student_name',
                    name:'student_name'
                },
                {
                   data:'id',
                    render:function(data,type,row){
                        return '<a href="'+baseurl+'/feedback/lines/view/'+data+'"><span class="txt-primary">View</span></a>';
                    },
                    name:'id' 
                }
            ]
        });
    }

    </script>
@endsection