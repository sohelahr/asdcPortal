@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Profiles</h3>
		@endslot
            <li class="breadcrumb-item active" aria-current="page">User Profiles</li>
	@endcomponent
    <div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
	            <div class="card">
                    @if(\App\Http\Helpers\CheckPermission::hasPermission('create.profiles'))
                        <div class="d-flex p-1 m-0 border header-buttons">
                            <div>
                                <a href="{{route('subadmin_student_create')}}">
                                    <button class="btn bg-white" type="button" data-toggle="modal" data-target="#employed-modal">
                                        <i class="fa fa-plus btn-icon-prepend"></i>
                                        Register A Student
                                    </button>
                                </a>
                            </div>
                        </div>
                    @endif
	                {{-- <div class="card-header">
	                    <h5>Deferred rendering for speed</h5>
	                    <span>The example below shows DataTables with deferred rendering enabled. For this small example you'll likely notice no difference, but larger tables can benefit significantly from simply enabling this parameter.</span>
	                </div> --}}
	                <div class="card-body">
                        <div class="table-responsive">
                            <table class="display datatables" id="userprofiles">
                                 <thead class="bg-primary">
                                    <tr>
                                        <th style="width: 30px">No</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tfoot class="bg-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Type</th>
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
            Notify('Created','Student Was Successfully Created','success')   
        @elseif(\Illuminate\ Support\ Facades\ Session::has('updated'))
            Notify('Updated','Student Was Successfully Updated','info')
        @elseif(\Illuminate\ Support\ Facades\ Session::has('not_completed'))
            Notify('Error','Student Profile Not Completed','danger')
        @elseif(\Illuminate\ Support\ Facades\ Session::has('error'))
            Notify('Danger','Something went wrong','danger')
        @endif
    $(document).ready( function () {
        $('#userprofiles').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            ajax: {
                "url": "{{route('user_profile_data')}}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
                //"complete": afterRequestComplete
            },
            columnDefs: [{
                "defaultContent": "-",
                orderable:false,
                "targets": "_all"
                },
                {
                    className: 'text-center',
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
                            return "<a href='userprofile/admin/"+row.id+"/view' class='text-capitalize' target='_blank'>"+data['name']+"</a>"
                        }
                        else{
                            return "<p class='mb-0 text-capitalize'>"+data['name']+"</p>"
                        }
                    }
                    else{
                        return data['name'];
                    }
                },
                name:"name",searchable: true
                },
                {data: 'mobile',name:"mobile"},
                {data: 'email',name:"email"},
                {data:'type',render:function(data,type,row){
                    //this will be rendered from server just for demo here
                    if(data == "True")
                    return "<p class='text-success mb-0'>Registered</p>"
                    else
                        return "<p class='text-warning mb-0'>Not Registered</p>"
                    },
                name:'type'
                },
                {data: 'edit',render:function(data,type,row){
                    if(data)
                        return "<a href='userprofile/admin/"+row.id+"/edit/' target='_blank'><i class='fa fa-pencil'></i></a>"
                    },
                ordering:false
                },
            ]
        });
    });
</script>
@endsection