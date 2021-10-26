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
                        
                <form id="add_security_permission_form" action="{{route('set_security_permissions')}}" method="POST">
                    <input type="hidden" name="user_id" value="{{$user_details->id}}">
                    @csrf
             
                    <div class="row align-items-stretch">
                        @foreach($permission_arr as $module => $permissions)
                            <div class="col-md-6 col-sm-12 ">
                                <div class="form-group p-3">
                                    <div>
                                        <h5 class="form-label">{{$module}}</h5>
                                    </div>
                                    <div class="row m-0">
                                        @foreach($permissions as $key => $permission)
                                            <div class="col-md-6 p-1">
                                                    <div class="form-check form-check-primary">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" @if(count($user_permission) > 0 && in_array($permission['id'], $user_permission)) checked @endif
                                                        class="form-check-input" name="permissions[]"  value="{{$permission['id']}}">
                                                        {{$permission['name']}}
                                                    <i class="input-helper"></i></label>
                                                </div> 
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                <div class="p-2">            
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a class="btn btn-light" href="{{url('admin/dashboard')}}">Cancel</a>
                </div>

                </form>
            </div>
                        <!-- /.card -->
        </div>

@endsection