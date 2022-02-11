@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Employments</h3>
		@endslot
            <li class="breadcrumb-item active" aria-current="page">Employments</li>
	@endcomponent
    <div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
                    
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table class="diplay datatables" id="admissions">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Course Name</th>
                                        <th>Company Name</th>
                                        <th>Location</th>
                                    </tr>
                                </thead>
                                <tfoot class="bg-primary">
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Course Name</th>
                                        <th>Company Name</th>
                                        <th>Location</th>
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
        @if(\Illuminate\Support\Facades\Session::has('created'))    
            $.toast({
                heading: 'Created',
                text: 'Successfully Admitted',
                position:'top-right',
                icon: 'success',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            $.toast({
                heading: 'Updated',
                text: 'Successfully Updated',
                position:'top-right',
                icon: 'info',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            $.toast({
                heading: 'Deleted',
                text: 'Successfully Deleted',
                position:'top-right',
                icon: 'warning',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
            
        @elseif(\Illuminate\Support\Facades\Session::has('error'))
            $.toast({
                heading: 'Danger',
                text: 'Something Went Wrong ',
                position:'top-right',
                icon: 'danger',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @endif
    
    $(document).ready( function () {
        $('#admissions').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('all_student_employements')}}",
            columns:[
                {data: 'student_name',render:function(data,type,row){
                    if(data['perm']){
                        return "<a href='studentemployment/view/"+row.id+"' class='txt-primary'>"+data['student_name']+"</a>"
                    }
                    else{
                        return "<p class='mb-0'>"+data['student_name']+"</p>"
                    }
                    }, name: 'student_name'},
                {data: 'course_name', name: 'course_name'},
                {data: 'company_name',name:"company_name"},
                {data: 'location',name:"location"},
                /* {data: 'date',name:"date"},*/
                /* {data:'type',render:function(data,type,row){
                    if(row.status == '1'){
                        return '<p class="badge badge-pill badge-primary">admitted</p>'
                    }
                    else if(row.status == '2'){
                        return '<p class="badge badge-pill badge-info">completed</p>'
                    }
                    else if(row.status == '3'){
                        return '<p class="badge badge-pill badge-success"> employed </p>'
                    }
                    else if(row.status == '4'){
                        return '<p class="badge badge-pill badge-warning">cancelled</p>'
                    }
                    else{
                        return '<p class="badge badge-pill badge-danger">terminated</p>'
                    }
                },name:'status'}, */
                /* {data:'Action',render:function(type,data,row){
                        return "<a href='admission/edit/"+row.id+"' class='badge badge-primary badge-pill'>Edit</a>"
                },name:'action'}, */
            ]
        });
} );
</script>
@endsection