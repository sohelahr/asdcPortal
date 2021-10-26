<x-app-layout>
    <x-slot name="header">
        <h5 class="font-semibold text-m text-gray-800 leading-tight">
            {{ __('My Courses') }}
        </h5>
    </x-slot>
    <div id="overlay-loader" class="d-none">
        <div style="height: 100%;width:100%;background:rgba(121, 121, 121, 0.11);position: absolute;z-index:999;" class="d-flex justify-content-center align-items-center"> 
            <div> 
                <div class="dot-opacity-loader">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>                
            </div>
        </div>
    </div>

    <div id="complete_profile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-danger" id="my-modal-title">Notice : </h3>
                </div>
                <div class="modal-body">
                    <h5>To enroll in a course, please complete your profile.</h5>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('logout') }}" class="px-2">
                        @csrf
                        <input type="submit" value="Logout" class="btn btn-info">
                    </form>
                    <a class="btn btn-warning" href="{{route('profile_update')}}">Complete Profile</a>
                </div>
            </div>
        </div>
    </div>

    <div id="profile_suspended" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-danger" id="my-modal-title">Notice : </h3>
                </div>
                <div class="modal-body">
                    <h5>Your Profile has been suspended</h5>
                    <p>You wont be able to enroll in any of the courses till
                        {{date('d M Y',strtotime($profile->suspended_till))}}
                    </p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('logout') }}" class="px-2">
                        @csrf
                        <input type="submit" value="Logout" class="btn btn-info">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">               
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="float-right">
                        <button class="btn btn-outline-primary btn-fw" type="button" data-toggle="modal" data-target="#enroll-modal">
                            Enroll In A Course
                        </button>
                    </div>
                    <div class="pt-5 mt-6">
                        <table class="table table-hover" id="registrations">
                        <thead>
                            <tr>
                                <th>Registration Number</th>
                                <th>Course Name</th>
                                <th>Course Timing</th>
                                <th>Registered On</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        {{-- <tfoot>
                            <tr>
                                <th>Registration Number</th>

                                <th>Course Name</th>
                                <th>Course Timing</th>
                                <th>Registered On</th>
                                <th>Status</th>
                            </tr>
                        </tfoot> --}}
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="enroll-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Course Enrollment</h5>
                </div>
                <form method="POST" id="enrollment_form" action="{{route('user_registration_create')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Course <sup class="text-danger">*</sup></label>
                                    <select class="form-control" name="course_id" id="registration_course">
                                        <option value="">Choose A Course</option>
                                        @foreach ($courses as $course)
                                            <option value="{{$course->id}}">{{$course->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Course Duration</label>
                                    <input required type="text" class="form-control form-control-sm" id="course_duration"
                                        value="" disabled>
                                </div>
                            </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Course Timing <sup class="text-danger">*</sup></label>
                                        <select class="form-control" name="courseslot_id" id="course_slot">
                                            <option value="">Choose Course Timing</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" onclick="closeModal()">Close</a>    
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@section('jcontent')
    <script>
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        @if(! $profile->is_profile_completed)
            $("#complete_profile").modal({
                backdrop: 'static',
                keyboard: false,
                show:true,
            })
        @endif

        @if($profile->is_suspended)
            $("#profile_suspended").modal({
                backdrop: 'static',
                keyboard: false,
                show:true,
            })
        @endif

        @if(\Illuminate\Support\Facades\Session::has('profile_complete'))    
                $.toast({
                    heading: 'Profile Complete',
                    text: 'Please Contact admin to make changes to your profile',
                    position:'top-right',
                    icon: 'danger',
                    loader: true,        // Change it to false to disable loader
                    loaderBg: '#9EC600'  // To change the background
                })
            @elseif(\Illuminate\Support\Facades\Session::has('profile_not_complete'))
                $.toast({
                    heading: 'Danger',
                    text: 'First Update Your Profile',
                    position:'top-center',
                    icon: 'danger',
                    loader: true,        // Change it to false to disable loader
                    loaderBg: '#9EC600'  // To change the background
                })
                
            @elseif(\Illuminate\Support\Facades\Session::has('profile_updated'))
                $.toast({
                    heading: 'success',
                    text: 'Profile was successfully updated',
                    position:'top-center',
                    icon: 'success',
                    loader: true,        // Change it to false to disable loader
                    loaderBg: '#9EC600'  // To change the background
                })
            @elseif(\Illuminate\Support\Facades\Session::has('registered'))
                $.toast({
                    heading: 'Registered',
                    text: 'You have successfully registered For a course',
                    position:'top-right',
                    icon: 'success',
                    loader: true,        // Change it to false to disable loader
                    loaderBg: '#9EC600'  // To change the background
                })
                
            @elseif(\Illuminate\Support\Facades\Session::has('already_registered'))
                $.toast({
                    heading: 'Warning',
                    text: 'You have already registered for two courses please visit the center before applying for more',
                    position:'top-right',
                    icon: 'warning',
                    loader: false,        // Change it to false to disable loader
                    loaderBg: '#9EC600'  // To change the background
                })
                
            @elseif(\Illuminate\Support\Facades\Session::has('error'))
                $.toast({
                    heading: 'Danger',
                    text: 'Something went wrong ',
                    position:'top-right',
                    icon: 'danger',
                    loader: true,        // Change it to false to disable loader
                    loaderBg: '#9EC600'  // To change the background
                })
            @endif
        function deleteRegistration(reg_id){
            swal({
                    title: "Withdraw Application",
                    text: "Are you sure you want to withraw your application",
                    icon: "warning",
                    buttons: ['Cancel','Withdraw'],
                    dangerMode: true,
                }).then((withdraw) => {
                        if (withdraw) {
                            $.ajax({
                                type: "post",
                                url: `{{url('registration/withdraw/${reg_id}')}}`,
                                data: "data",
                                dataType: "dataType",
                                beforeSend:function(){
                                    $('#overlay-loader').removeClass('d-none');
                                    $('#overlay-loader').show();
                                },
                                statusCode: {
                                    200: function (response) {
                                            table.draw();
                                            swal("You have successfully withdrawn your application", {
                                                icon: "success",
                                            });
                                            $('#overlay-loader').hide();
                                        },
                                    401: function () {
                                        swal("Something went wrong", {
                                                icon: "warning",
                                            });
                                        $('#overlay-loader').hide();    
                                      }
                                }
                            });
                        }
                    });
        }
        var table = $('#registrations').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('user_registrations')}}",
                columns:[
                    /* {data: 'student_name', name: 'student_name'}, */
                    {data: 'registration_no', name: 'registration_no'},
                    {data: 'course_name',name:"course_name"},
                    {data: 'course_slot',name:"course_slot"},
                    {data: 'date',name:"date"},
                    {data:'status',render:function(type,data,row){
                        if(row.status == "1"){
                            return `<label class='badge badge-warning badge-pill px-4'>Applied</label>`
                        }
                        else if(row.status == "2"){
                            return "<label class='badge badge-success badge-pill px-3'>Admitted</label>"
                        }
                        else if(row.status == "3"){
                            return "<label class='badge badge-danger badge-pill px-3'>Cancelled</label>"
                        }
                    },
                    name:'status'
                    },
                    {data:'action',render:function(type,data,row){
                            if(row.status == "1"){
                                return `<button type="button" class="btn btn-warning btn-rounded py-2" 
                                            onclick='deleteRegistration(${row.id})'
                                            >
                                            <i class="fas fa-times"></i>                    
                                        </button>`
                            }
                            else if(row.status == "2"){
                                return `<button type="button" class="btn btn-primary btn-rounded py-2">
                                            <i class="fa fa-id-card" style="font-size: 0.9rem;"></i>                          
                                        </button>`
                            }
                            else{
                                return `<button type="button" class="btn btn-danger btn-rounded py-2">
                                            <i class="fa fa-frown"></i>                          
                                        </button>`
                            }
                        }
                    }
                ]
            });
            
    
        
        
        $(document).ready(function () {
             $('#enrollment_form').validate({
                errorClass: "text-danger pt-1",            
                rules: {     
                    course_id: {
                        required: true,
                    },
                    courseslot_id: {
                        required: true,
                    },  
                },
                messages: {
                    course_id: {
                        required: "Course is required",
                    },
                    courseslot_id: {
                        required: "Please select a timing",
                    },  
                },
                submitHandler: function (form, event) { 
                    event.preventDefault();
                    console.log( $(form).serialize());
                    $.ajax({
                        url: form.action,
	                    type: form.method,
                        data: $(form).serialize(),
                        beforeSend: function () {
                            $('#overlay-loader').removeClass('d-none');
                            $('#overlay-loader').show();
                            closeModal();
                        },
                        success: function (response) {
                            if(response.status == "success"){
                                $.toast({
                                    heading: 'Success',
                                    text: response.msg,
                                    position:'top-center',
                                    icon: 'success',
                                    loader: true,        // Change it to false to disable loader
                                    loaderBg: '#9EC600'
                                });
                            }
                            else{
                                swal({
                                    title: 'Warning',
                                    text: response.msg,
                                    icon: 'warning',
                                });
                            }
                            table.draw();
                            $('#overlay-loader').hide();
                        },
                    });
                },
            });
        }); 
        function closeModal(){
            $('#enroll-modal').modal('hide');
        }
        $("#registration_course").on('change',function(){
            let course_id = $("#registration_course").val()
            $.ajax({
                type: "get",
                url: `{{url('registration/getforminputs/${course_id}')}}`,
                success: function (response) {
                    $("#course_slot").empty();
                    $("#course_duration").val(response.course_duration);;
                    if(response.course_slots.length > 0){
                        $.each(response.course_slots, function (index, element) { 
                            $("#course_slot").append(`
                                <option value="${element.id}">${element.name}</option>
                            `);
                        });
                    }
                    else
                    {
                        $("#course_slot").append(`
                                <option value="">Not Found</option>
                        `);
                    }
                },
            });
        });
    </script>
@endsection
</x-app-layout>
