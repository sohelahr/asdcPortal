@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Registrations
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrations</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        
        <div class="card-body">
            
            <div class="table-responsive">
                         <table class="table table-hover" id="registrations">
                    <thead>
                        <tr>
                            <th style="width: 30px">No</th>
                            <th>Student Name</th>
                            <th>Course Name</th>
                            <th>Course Timing</th>
                            <th>Registered On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                     <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Student Name</th>
                            <th>Course Name</th>
                            <th>Course Timing</th>
                            <th>Registered On</th>
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
    
    $(document).ready( function () {
    $('#registrations').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{route('all_registrations')}}",
        columns:[
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'student_name', name: 'student_name'},
            {data: 'course_name',name:"course_name"},
            {data: 'course_slot',name:"course_slot"},
            {data: 'date',name:"date"},
            {data:'Action',render:function(type,data,row){
                    return "<a class='badge badge-success badge-pill' href='admission/create/"+row.id+"'>Admit</a>"
                },name:'action'}
        ]
    });
} );
</script>
@endsection