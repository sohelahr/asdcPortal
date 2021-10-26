@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Admissions
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Admissions</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        
        <div class="card-body">
            
            <div class="table-responsive">
                         <table class="table table-hover" id="admissions">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Course Name</th>
                            <th>View</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                     <tfoot>
                        <tr>
                            <th>Student Name</th>
                            <th>Course Name</th>
                            <th>View</th>
                            <th>Action</th>
                        </tr>
                     </tfoot>
                </table>
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
            ajax: "{{route('all_admissions')}}",
            columns:[
                {data: 'student_name',render:function(data,type,row){
                    return "<a href='admission/view/"+row.id+"'>"+data+"</a>"
                    }, name: 'student_name'},
                {data: 'roll_no', name: 'roll_no'},
                {data: 'course_slot',name:"course_slot"},
                {data: 'date',name:"date"},
                {data:'status',render:function(data,type,row){
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
                },name:'status'},
                {data:'Action',render:function(type,data,row){
                        return "<a href='admission/edit/"+row.id+"' class='badge badge-primary badge-pill'>Edit</a>"
                },name:'action'},
            ]
        });
} );
</script>
@endsection