@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Qualifications
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Qualifications</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div id="overlay-loader" class="d-none">
            <div style="height: 100%;width:100%;background:rgba(121, 121, 121, 0.11);position: absolute;z-index:999;" class="d-flex justify-content-center align-items-center"> 
                <div >  
                    
                        <div class="dot-opacity-loader">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="float-right my-2">
                @if(\App\Http\Helpers\CheckPermission::hasPermission('create.qualifications'))      
                    <button class="btn btn-outline-primary btn-fw" type="button" data-toggle="modal" data-target="#qualification-create">
                        + Create
                    </button>
                @endif
            </div>    
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 85%">Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($qualifications as $qualification)
                            <tr>
                                <td>{{$qualification->name}}</td>
                                <td class="d-flex p-1">
                                @if(\App\Http\Helpers\CheckPermission::hasPermission('update.qualifications'))      
                                    <button class="btn btn-dark btn-rounded p-2" onclick="Editqualification({{$qualification->id}})">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                @endif
                                @if(\App\Http\Helpers\CheckPermission::hasPermission('delete.qualifications'))      
                                    <form action="{{url('qualification/delete/'.$qualification->id)}}" method="post" class="ml-2 mb-0">
                                        @csrf
                                        <button type=submit class="btn btn-danger btn-rounded p-2 mb-0">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="qualification-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="qualification-create-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{url('qualification/create')}}" id="myForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="qualification-create-title">Create Qualification</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name <sup class="text-danger">*</sup></label>
                            <input id="name" class="form-control form-control-sm" type="text" name="name" placeholder="eg: BCA">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Submit" class="btn btn-primary">    
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

    <div id="qualification-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="document-create-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{url('qualification/edit')}}" id="edit-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="document-create-title">Edit Document</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name <sup class="text-danger">*</sup></label>
                            <input id="edit-name" class="form-control form-control-sm" type="text" name="name" placeholder="eg: Bachelor of Science">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Submit" class="btn btn-primary">
                        <a class="btn btn-secondary" onclick="closeModal()">Close</a>    

                    </div>
                </form>
            </div>
        </div>
    </div>

@section('jcontent')
    <script>
        function closeModal(){
            $('#qualification-edit').modal('hide');
        }
        @if(\Illuminate\Support\Facades\Session::has('created'))    
            $.toast({
                heading: 'Created',
                text: 'Qualification Was Successfully Created',
                position:'top-right',
                icon: 'success',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            $.toast({
                heading: 'Updated',
                text: 'Qualification Was Successfully Updated',
                position:'top-right',
                icon: 'info',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            $.toast({
                heading: 'Deleted',
                text: 'Qualification Was Successfully Deleted',
                position:'top-right',
                icon: 'warning',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('prohibited'))
            $.toast({
                heading: 'Cannot Delete',
                text: 'This Qualification already has registrations',
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
        
        function Editqualification(qualification_id){
            getEditData(qualification_id);
        }

        function getEditData(qualification_id){
            console.log(qualification_id)
            $.ajax({
                type: "get",
                url: `{{url('qualification/edit/${qualification_id}')}}`,
                beforeSend: function () {
                    $('#overlay-loader').removeClass('d-none');
                    $('#overlay-loader').show();

                },
                success: function (response) {
                    data = JSON.parse(response);

                    $("#edit-form").attr("action", `{{url('qualification/edit/${qualification_id}')}}`);
                    $("#edit-name").val(data.name);
                    $("#qualification-edit").modal('show');

                },
                complete: function () {
                    $('#overlay-loader').hide();
                },
            });
        }
        $(document).ready(function () {
             $('#myForm').validate({
                errorClass: "text-danger pt-1",            
                rules: {     
                    name: {
                        required: true,
                    },
                    
                },

                messages: {
                    name:{
                        required: "Please Add Name",
                    },
                    
                } 

            });
             $('#edit-form').validate({
                errorClass: "text-danger pt-1",            
                rules: {     
                    name: {
                        required: true,
                    },
                    
                },

                messages: {
                    name:{
                        required: "Please Add Name",
                    },
                    
                } 

            });
        });
 
    </script>
    
@endsection