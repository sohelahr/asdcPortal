@extends('layouts.admin.app')
@section('title')
    <title>Asdc | Import</title>
@endsection
@section('content')
<div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                Import Registrations
            </h3>
        </div>
        <div class="row grid-margin">
            <div class="col-12">
                <div class="card">
                    <div id="gauge-loader" class="d-none">
                        <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                            <div class="bar-loader">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>    
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <a href="{{url('admin/import-users')}}" onclick="startLoader()" class="btn btn-outline-info my-3">Create Users</a>
                            <a href="{{url('admin/import-profiles')}}" onclick="startLoader()" class="btn btn-outline-primary my-3">Update Profiles</a>
                            <a href="{{url('admin/import-registrations')}}" onclick="startLoader()" class="btn btn-outline-warning my-3">Create Registrations</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
@section('jcontent')
    <script>
            function startLoader(){
                $('#gauge-loader').removeClass('d-none');
            }       
    </script>   
@endsection