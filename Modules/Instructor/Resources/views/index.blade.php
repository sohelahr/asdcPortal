@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Instructor
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Instructor</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        @if(\App\Http\Helpers\CheckPermission::hasPermission('create.profiles'))
            <div class="d-flex p-1 m-0 border header-buttons">
                <div>
                    <a href="{{route('create_instructor')}}">
                        <button class="btn bg-white" type="button" data-toggle="modal" data-target="#employed-modal">
                            <i class="fas fa-user-plus btn-icon-prepend"></i>
                            Add A Instructor
                        </button>
                    </a>
                </div>
            </div>
        @endif
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-hover" id="userprofiles">
                    <thead>
                        <tr>
                            <th style="width: 30px">No</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                     <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Edit</th>
                        </tr>
                     </tfoot>
                </table>
            </div>
        </div>
    </div>

    
@endsection
@section('jcontent')
<script>
        @if(\Illuminate\ Support\ Facades\ Session::has('created'))
            $.toast({
                heading: 'Created',
                text: 'Instrutor Was Successfully Created',
                position: 'top-right',
                icon: 'success',
                loader: true, // Change it to false to disable loader
                loaderBg: '#9EC600' // To change the background
            })
        @elseif(\Illuminate\ Support\ Facades\ Session::has('updated'))
            $.toast({
                heading: 'Updated',
                text: 'Instructor Was Successfully Updated',
                position: 'top-right',
                icon: 'info',
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
    $(document).ready( function () {
    $('#userprofiles').DataTable({
        processing: true,
        serverSide: true,
        "pageLength": 50,
        ajax: {
            "url": "{{route('instructor_data')}}",
            "dataType": "json",
            "type": "POST",
            "data":{ _token: "{{csrf_token()}}"}
            //"complete": afterRequestComplete
        },
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
        }],
        columns:[
            {data: 'DT_RowIndex', name: 'DT_RowIndex',searchable: false},
            {data: 'name',render:function(data,type,row){
                
                if(type === "filter")
                {
                    return data['name'].toString();
                }
                //this will be rendered from server just for demo here
                else if(type === "display"){
                    if(data['perm']){
                        return "<a href='instructor/"+row.id+"/view'>"+data['name']+"</a>"
                    }
                    else{
                        return "<p class='mb-0'>"+data['name']+"</p>"
                    }
                }
                else{
                    return data['name'];
                }
            },
            name:"name",searchable: true
            },
            {data: 'phone',name:"phone"},
            {data: 'email',name:"email"},
            {data:'course',name:'course'},
            {data: 'edit',render:function(data,type,row){
                if(data)
                    return "<a href='instructor/"+row.id+"/update/' class='btn btn-dark btn-rounded p-2 mr-2'><i class='fas fa-pencil-alt'></i></a>"
                else
                    return "<a href='#' class='btn btn-dark btn-rounded p-2 mr-2'><i class='fas fa-frown'></i></a>"
                },
            },
        ]
    });
} );
</script>
@endsection