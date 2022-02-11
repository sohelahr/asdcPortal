@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Instructors</h3>
		@endslot
            <li class="breadcrumb-item active" aria-current="page">Instructors</li>
	@endcomponent
    <div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
                    @if(\App\Http\Helpers\CheckPermission::hasPermission('create.profiles'))
                        <div class="d-flex p-1 m-0 border header-buttons">
                            <div>
                                <a href="{{route('create_instructor')}}">
                                    <button class="btn bg-white" type="button" data-toggle="modal" data-target="#employed-modal">
                                        <i class="fa fa-plus btn-icon-prepend"></i>
                                        Add Instructor
                                    </button>
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table class="display datatables" id="userprofiles">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style="width: 30px">No</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Course</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tfoot class="bg-primary">
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
        @if(\Illuminate\ Support\ Facades\ Session::has('created'))
            Notify('Created','Instrutor Was Successfully Created','success')
        @elseif(\Illuminate\ Support\ Facades\ Session::has('updated'))
            Notify('Updated','Instructor Was Successfully Updated','info')
        @elseif(\Illuminate\ Support\ Facades\ Session::has('error'))
            Notify('Danger','Something Went Wrong','danger')
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
            },{
                'class':'text-center',
                'targets':[5]
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
                        return "<a href='instructor/"+row.id+"/update/' class='text-secondary'><i class='fa fa-pencil'></i></a>"
                    else
                        return
                    },
                },
            ]
        });
    });
</script>
@endsection