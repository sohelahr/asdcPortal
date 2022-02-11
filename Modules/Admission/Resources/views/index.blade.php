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
                    <div class="card-body">
                        <div class="table-responsive">
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
    
    $(document).ready( function () {
        $('#admissions').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            searching: true,
            "autoWidth": false,
            "responsive": true,
            ajax: {    
                "url": "{{route('all_admissions')}}",
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
} );
</script>
@endsection