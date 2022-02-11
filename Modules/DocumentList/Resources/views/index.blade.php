@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Documents</h3>
		@endslot
            <li class="breadcrumb-item active" aria-current="page">Documents</li>
	@endcomponent
    <div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
                    <div id="overlay-loader" class="d-none">
                            <div style="height: 100%;width:100%;background:rgba(121, 121, 121, 0.11);position: absolute;z-index:999;" class="d-flex justify-content-center align-items-center"> 
                                <div> 
                                    <div class="loader-box">
                                        <div class="loader-7"></div>
                                    </div>              
                                </div>
                            </div>
                        </div>
                    @if(\App\Http\Helpers\CheckPermission::hasPermission('create.documents'))
                        <div class="d-flex p-1 m-0 border header-buttons">
                            <div>
                                <button class="btn bg-white" type="button" data-bs-toggle="modal" data-bs-target="#document-create">
                                    <i class="fa fa-plus btn-icon-prepend"></i>
                                    Create
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="card-body">    
                        <div class="table-responsive">
                            <table class="display datatables" id="documents_table">
                                <thead>
                                    <tr class="bg-primary">
                                        <th>No</th>
                                        <th style="width: 85%">Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="document-create" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="document-create-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{url('documentlist/create')}}" id  = "myForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="document-create-title">Create Document</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name <sup class="text-danger">*</sup></label>
                            <input id="name" class="form-control" type="text" name="name" placeholder="eg: Adhaar">
                          
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Submit" class="btn btn-primary" onsubmit="validateform()">    
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="documentlist-edit" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="document-create-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{url('documentlist/edit')}}" id="edit-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="document-create-title">Edit Document</h5>
                        
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name <sup class="text-danger">*</sup></label>
                            <input id="edit-name" class="form-control" type="text" name="name" placeholder="eg: Adhaar">
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
        function deleteDocumentConfirm(id){
            swal({
                title: "Warning",
                text: 'You sure want to delete',
                icon:'warning',
                buttons: ['Back','Yes I\'m Sure'],
                dangerMode: true,
                }).then((yes_delete) => {
                    if (yes_delete) {
                           $('#delete_form_'+id).submit();    
                    }
                    else
                    return null;
                });
        }
        function closeModal(){
            $('#documentlist-edit').modal('hide');
        }
        @if(\Illuminate\Support\Facades\Session::has('created'))    
            Notify('Created','Document Was Successfully Created','success')
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            Notify('Updated','Document Was Successfully Update','info')
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            Notify('Deleted','Document Was Successfully Deleted','warning')
        @elseif(\Illuminate\Support\Facades\Session::has('error'))
            Notify('Danger','Something Went Wrong','danger')  
        @elseif(\Illuminate\Support\Facades\Session::has('prohibited'))
            Notify('Cannot Delete','This document already has admissions','warning')
        @endif
        function Editdocumentlist(documentlist_id){
            getEditData(documentlist_id);
        }

        function getEditData(documentlist_id){
            console.log(documentlist_id)
            $.ajax({
                type: "get",
                url: `{{url('documentlist/edit/${documentlist_id}')}}`,
                beforeSend: function () {
                    $('#overlay-loader').removeClass('d-none');
                    $('#overlay-loader').show();
                },
                 success: function (response) {     
                    data = JSON.parse(response);
                    $("#edit-form").attr("action", `{{url('documentlist/edit/${documentlist_id}')}}`);
                    $("#edit-name").val(data.name);
                    $("#documentlist-edit").modal('show');  

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

            $('#documents_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('document_list_data')}}",
                /* columnDefs: [{
                "defaultContent": "-",
                orderable:false,
                "targets": "_all"
                }], */
                columns:[
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name',name:"name"},
                    {data: 'perm',render:function(data,type,row){
                        return `<div>
                                    <div  class="d-flex p-0 m-0">
                                        ${data.edit_perm ? 
                                        `<button class="form-btn form-btn-warning ms-4 me-2" onclick="Editdocumentlist(${row.id})">
                                            <i class="fa fa-pencil"></i>
                                        </button>` 
                                        : null}
                                        ${data.delete_perm ? 
                                        
                                        `<div class="ml-2">
                                                    <button type=submit class="form-btn form-btn-danger ms-2" onclick="deleteDocumentConfirm(${row.id})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                            </div>        
                                                <form action='documentlist/delete/${row.id}' id='delete_form_${row.id}' method="post" class="d-none">
                                                    @csrf
                                                </form>
                                        `: null}
                                    </div>
                                </div>`
                    },name:'perm'}
                ]
            });

        });
 

        
    </script>
    
@endsection