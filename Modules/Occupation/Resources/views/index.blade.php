@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Occupations
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Occupations</li>
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
                <button class="btn btn-outline-primary btn-fw" type="button" data-toggle="modal" data-target="#occupation-create">
                    + Create
                </button>
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
                        @foreach ($occupations as $occupation)
                            <tr>
                                <td>{{$occupation->name}}</td>
                                <td class="d-flex p-1">
                                    <button class="btn btn-dark btn-rounded p-2" onclick="Editoccupation({{$occupation->id}})">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <form action="{{url('occupation/delete/'.$occupation->id)}}" method="post" class="ml-2">
                                        @csrf
                                        <button type=submit class="btn btn-danger btn-rounded p-2">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="occupation-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="occupation-create-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{url('occupation/create')}}" id="myForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="occupation-create-title">Create Occupation</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" class="form-control form-control-sm" type="text" name="name" placeholder="eg: Software Developer">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Submit" class="btn btn-primary">    
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div id="occupation-edit" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="document-create-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{url('occupation/edit')}}" id="edit-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="document-create-title">Edit Document</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="edit-name" class="form-control form-control-sm" type="text" name="name">
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
@endsection
@section('jcontent')
    <script>
        function closeModal(){
            $('#occupation-edit').modal('hide');
        }
        @if(\Illuminate\Support\Facades\Session::has('created'))    
            $.toast({
                heading: 'Created',
                text: 'Occupation Was Successfully Created',
                position:'top-right',
                icon: 'success',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            $.toast({
                heading: 'Updated',
                text: 'Occupation Was Successfully Updated',
                position:'top-right',
                icon: 'info',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            $.toast({
                heading: 'Deleted',
                text: 'Occupation Was Successfully Deleted',
                position:'top-right',
                icon: 'warning',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('prohibited'))
            $.toast({
                heading: 'Cannot Delete',
                text: 'This Occupation already has registrations',
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
        
        function Editoccupation(occupation_id){
            getEditData(occupation_id);
        }

        function getEditData(occupation_id){
            $.ajax({
                type: "get",
                url: `{{url('occupation/edit/${occupation_id}')}}`,
                beforeSend: function () {
                    $('#overlay-loader').removeClass('d-none');
                    $('#overlay-loader').show();

                },
                success: function (response) {
                    data = JSON.parse(response);

                    $("#edit-form").attr("action", `{{url('occupation/edit/${occupation_id}')}}`);
                    $("#edit-name").val(data.name);
                    $("#occupation-edit").modal('show');

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
