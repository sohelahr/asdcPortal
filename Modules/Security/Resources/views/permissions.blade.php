@extends('layouts.admin.app')

@section('content')
@component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Security Permissions For {{$user_details->name}}</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('/subadmin')}}">Staff</a></li>
            <li class="breadcrumb-item active" aria-current="page">Permission</li>
	@endcomponent
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
                            <div class="col-md-12 mb-2 col-12">
                                    <div>
                                        <label class="form-label text-dark">
                                            @php
                                            echo preg_replace('/([A-Z])/',' $1', $module);   
                                            @endphp 
                                        </label>
                                    </div>
                                    <div class="row align-items-start justify-content-start ms-1">
                                        @foreach($permissions as $key => $permission)
                                            <div class="col-md-3  col-12">
                                                <div class="form-group m-checkbox-inline mb-0">
                                                    <div class="checkbox checkbox-primary">
                                                        <input id="inline-{{$permission['id']}}"
                                                            @if(count($user_permission) > 0 && in_array($permission['id'], $user_permission)) checked @endif
                                                            name="permissions[]"  value="{{$permission['id']}}"
                                                        type="checkbox">
                                                        <label for="inline-{{$permission['id']}}" class="form-label">{{$permission['name']}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                        <hr>
                            </div>
                        @endforeach
                    </div>
                <div class="p-2">            
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a class="btn btn-secondary" href="{{url('/subadmin')}}">Cancel</a>
                </div>

                </form>
            </div>
                        <!-- /.card -->
        </div>

@endsection