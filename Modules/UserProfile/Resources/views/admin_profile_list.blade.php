@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Profiles
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profiles</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-hover" id="userprofiles">
                    <thead>
                        <tr>
                            <th style="width: 30px">No</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Qualification</th>
                            <th>Type</th>
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
                            <th>Qualification</th>
                            <th>Type</th>
                            <th>Edit</th>
                        </tr>
                     </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- <div id="userprofile-edit" class="modal" tabindex="-1" role="dialog" aria-labelledby="userprofile-edit-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST"  id="edit-form" action="{{url('userprofile/edit/')}}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="userprofile-edit-title">Edit userprofile</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-danger" id="showtext">Please Wait...</h5>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="edit-name" class="form-control form-control-sm" type="text" name="name" placeholder="eg: Digital Marketing">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="Duration">Duration</label>
                                <input id="edit-Duration" class="form-control form-control-sm" type="text" name="duration" placeholder="eg : 3 months">
                            </div>
                            <div class="form-group col-6">
                                <label for="slug">Slug</label>
                                <input id="edit-slug" class="form-control form-control-sm" type="text" name="slug" placeholder="eg : DM">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Submit" class="btn btn-primary" >    
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    
@endsection
@section('jcontent')
<script>
        @if(\Illuminate\Support\Facades\Session::has('updated'))
            $.toast({
                heading: 'Updated',
                text: 'Profile Was Successfully Updated',
                position:'top-right',
                icon: 'info',
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
    $('#userprofiles').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{route('user_profile_data')}}",
        columns:[
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name',render:function(data,type,row){
                //this will be rendered from server just for demo here
                return "<a href='userprofile/admin/"+row.id+"/view'>"+row.name+"</a>"
                },
            name:"name"
            },
            {data: 'mobile',name:"mobile"},
            {data: 'qualification',name:"qualification"},
            {data:'type',render:function(data,type,row){
                //this will be rendered from server just for demo here
                console.log(data)
                if(data == "True")
                   return "<label class='badge badge-pill badge-success'>Registered</label>"
                else
                    return "<label class='badge badge-warning badge-pill'>Not Registered</label>"
                },
            name:'type'
            },
            {data: 'edit',render:function(type,data,row){
                return "<a href='/userprofile/admin/edit/"+row.id+"' class='btn btn-dark btn-rounded p-2 mr-2'><i class='fas fa-pencil-alt'></i></a>"
                },
            },
        ]
    });
} );
</script>
@endsection