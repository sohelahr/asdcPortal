<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('profile_update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">First Name</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="firstname" value="{{$userprofile->firstname}}">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Last Name</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="lastname" value="{{$userprofile->lastname}}">
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Gender</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="gender">
                                <option value="male" @if ($userprofile->gender == "male")
                                    selected
                                @endif>Male</option>
                                <option value="female" @if ($userprofile->gender == "female")
                                    selected
                                @endif>Female</option>
                                </select>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Date of Birth</label>
                            <div class="col-sm-9">
                                <div id="datepicker-popup" class="input-group date datepicker">
                                    <input required type="text" class="form-control" name="dob" value="{{$userprofile->dob}}">
                                    <span class="input-group-addon input-group-append border-left">
                                        <span class="far fa-calendar input-group-text"></span>
                                    </span>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Mobile Number</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="mobile" value="{{$userprofile->mobile}}">
                            </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Age</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="age" value="{{$userprofile->age}}">
                            </div>
                            </div>
                        </div>
                        </div>
                        <p class="card-description">
                        Address
                        </p>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">House Name/Number</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="house_details" value="{{$userprofile->house_details}}">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Street/Locality</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="street" value="{{$userprofile->street}}">
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Landmark</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="landmark" value="{{$userprofile->landmark}}">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Pincode</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="pincode" value="{{$userprofile->pincode}}">
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">City</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="city" value="{{$userprofile->city}}">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">State</label>
                            <div class="col-sm-9">{{-- 
                                <select class="form-control">
                                <option>America</option>
                                <option>Italy</option>
                                <option>Russia</option>
                                <option>Britain</option>
                                </select> --}}
                                <input required type="text" class="form-control" name="state" value="{{$userprofile->state}}">
                            </div>
                            </div>
                        </div>
                        </div>
                        
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Occupation</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="occupation_id">
                                @foreach ($occupations as $occupation)
                                <option value="{{$occupation->id}}" @if($occupation->id == $userprofile->occupation_id) selected @endif>{{$occupation->name}}</option>                                
                                @endforeach
                                </select> 
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Qualification</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="qualification_id">
                                @foreach ($qualifications as $qualification)
                                <option value="{{$qualification->id}}" @if($occupation->id == $userprofile->occupation_id) selected @endif>{{$qualification->name}}</option>                                
                                @endforeach
                                </select> 
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Qualification Specialization</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="qualification_specilization"
                                    value="{{$userprofile->qualification_specilization}}" placeholder="ex: Science/Mechanical/IT">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Qualification Status</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="qualification_status">
                                <option value="Passed" @if($userprofile->qualification_status == "Passed") selected @endif>Passed</option>                                
                                <option value="Pursuing" @if($userprofile->qualification_status == "Pursuing") selected @endif>Pursuing</option>                                
                                <option value="Completed" @if($userprofile->qualification_status == "Completed") selected @endif>Completed</option>                                
                                <option value="Left Incomplete" @if($userprofile->qualification_status == "Left Incomplete") selected @endif>Left Incomplete</option>                                

                                </select> 
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Registration Feedback</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="comments" value="{{$userprofile->comments}}">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">How You Got To Know About Us</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" value="{{$userprofile->how_know_us}}" name="how_know_us">
                            </div>
                            </div>
                        </div>
                        </div>
                        
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">School/College Name</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="school_name" value="{{$userprofile->school_name}}">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Upload Photo  </label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control-file" name="photo">
                                <sub>(Leave blank if already Uploaded)</sub>
                            </div>
                            </div>
                        </div>
                        </div>
                        
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Father's/Gaurdian's Name</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="father_name" value="{{$userprofile->father_name}}">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Father's/Gaurdian's Mobile</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="fathers_mobile" value="{{$userprofile->fathers_mobile}}">
                            </div>
                            </div>
                        </div>
                        </div>
                        
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Father's/Gaurdian's Income</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="fathers_income" value="{{$userprofile->fathers_income}}">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Father's/Gaurdian's Occupation</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="father_occupation" value="{{$userprofile->father_occupation}}">
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check form-check-primary">
                                    <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input mt-2" name="is_profile_completed" value="1">
                                        I agree that all the information filled above is correct and won't be changed for atleast one year.Leave blank if not yet sure
                                    <i class="input-helper"></i>
                                </label>
                                </div>
                            </div>
                        </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button><a class="btn btn-light" href="{{url('/dashboard')}}">Cancel</a>
                  </form>
                </div>
            </div>
        </div>
    </div>
    
@section('jcontent')
    <script>
        $('#datepicker-popup').datepicker(
            {format: 'yy/mm/dd',
                autoclose: true,
                todayHighlight: true}
        );
    </script>
@endsection
</x-app-layout>