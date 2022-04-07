@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Admissions</h3>
		@endslot
            <li class="breadcrumb-item active" aria-current="page">Admissions</li>
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
                                <button class="btn btn-primary" id="get-admission-btn"><i class="fa fa-search"></i></button>
                                <button class="btn btn-danger" id="reset-attendance-btn"><i class="icofont icofont-close"></i></button>
                            </div>
                        </div>
                        <div class="table-responsive mt-2">
                            <table class="display datatable" id="admissions">
                                <thead class="bg-success">
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Roll no.</th>
                                        <th>Course Name</th>
                                        <th>Course Slot</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        {{-- <th>Action</th> --}}
                                    </tr> 
                                </thead>
                                <tfoot class="bg-success">
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Roll no.</th>
                                        <th>Course Name</th>
                                        <th>Course Slot</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </tfoot>
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

    getAdmissions("{{route('all_admissions')}}");

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
        @if(\Illuminate\Support\Facades\Session::has('created'))    
            Notify('Created','Successfully Admitted','success')
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            Notify('Updated','Successfully Updated','info')
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            Notify('Deleted','Successfully Deleted','warning')        
        @elseif(\Illuminate\Support\Facades\Session::has('error'))
            Notify('Danger','Something Went Wrong','danger')        
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

    $('#get-admission-btn').on('click',function(){
        let courseid = $('#change_admission_by_batch').val();
        let slotid = $('#course_slot').val();
        let batchid = $('#course_batch').val();
        if(slotid == "" || batchid == ""){
            return null;
        }
        url = `{{url('admission/data/${courseid}/${slotid}/${batchid}')}}`;
        getAdmissions(url);
    });

    
    $('#reset-attendance-btn').on('click',function(){
        $('#change_admission_by_batch').prop('selectedIndex',0);
        $('#course_slot').prop('selectedIndex',0);
        $('#course_batch').prop('selectedIndex',0);
        getAdmissions("{{route('all_admissions')}}");
    });

    function getAdmissions(url){
        $('#admissions').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            searching: true,
            "autoWidth": false,
            "responsive": true,
            "bDestroy": true,
            ajax: {    
                "url": url,
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            },{
                className: 'text-center',
                'targets':[5]
            }], 
            columns:[
                {data: 'student_name',render:function(data,type,row){
                    if(row.perm){
                        return "<a href='admission/view/"+row.id+"' target='_blank'>"+data+"</a>"
                    }
                    else{
                        return "<p class='mb-0'>"+data+"</p>"
                    }
                }, name: 'student_name'},
                {data: 'roll_no', name: 'roll_no'},
                {data: 'course_name',name:"course_name"},
                {data: 'course_slot',name:"course_slot"},
                {data: 'date',name:"date"},
                {data:'status',render:function(data,type,row){
                    if(row.status == '1'){
                        return '<p class="txt-primary">Admitted</p>'
                    }
                    else if(row.status == '2'){
                        return '<p class="text-secondary">Completed</p>'
                    }
                    else if(row.status == '3'){
                        return '<p class="text-success">Employed</p>'
                    }
                    else if(row.status == '4'){
                        return '<p class="text-warning">Cancelled</p>'
                    }
                    else{
                        return '<p class="text-danger">Terminated</p>'
                    }
                },name:'status'},
               /*  {data:'Action',render:function(type,data,row){
                        return "<a href='admission/edit/"+row.id+"' class='badge badge-primary badge-pill'>Edit</a>"
                },name:'action'}, */
            ]
        });
    }
</script>
@endsection