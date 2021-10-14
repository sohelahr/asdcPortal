@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Security Permissions For {{$user_details->name}}
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sub Admins</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
                        
                <form id="add_security_permission_form" action="{{url('/security/set/permission')}}" method="POST">
                    <input type="hidden" name="user_id" value="{{$user_details->id}}">
                    @csrf
            
                    <div class="row">
                        @foreach($permission_arr as $module => $permissions)
                            <div class="col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header p-1">
                                        <h3 class="card-title my-2">{{$module}}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="row">
                                                @foreach($permissions as $key => $permission)
                                                    <div class="col-md-2">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input name="permissions[]"
                                                                    @if(count($user_permission) > 0 && in_array($permission['id'], $user_permission)) checked @endif
                                                                    value="{{$permission['id']}}"
                                                                    type="checkbox"> {{$permission['name']}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                <div class="p-2">            
                <button type="submit" class="btn btn-primary mr-2" onclick = "validate()">Submit</button>
                <a class="btn btn-light" href="{{url('admin/dashboard')}}">Cancel</a>
                </div>

                </form>
            </div>
                        <!-- /.card -->
        </div>

@endsection