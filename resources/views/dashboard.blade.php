<x-app-layout>
    <x-slot name="header">
        <h5 class="font-semibold text-m text-gray-800 leading-tight">
            {{ __('My Courses') }}
        </h5>
    </x-slot>

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
                    <a class="btn btn-warning" href="{{route('profile_update')}}">Complete Profile</a>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="float-right">
                        <a href="{{route('user_registration_create')}}">
                        <button class="btn btn-info btn-icon-text" >
                            Enroll In A Course
                            <i class="fa fa-plus btn-icon-prepend"></i>
                        </button>
                        </a>
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
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Registration Number</th>

                                <th>Course Name</th>
                                <th>Course Timing</th>
                                <th>Registered On</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('jcontent')
    <script>
        @if(! Auth::User()->UserProfile->is_profile_completed)
            $("#complete_profile").modal({
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
        $(document).ready( function () {
        $('#registrations').DataTable({
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
                    if(row.status == "1")
                        return "<label class='badge badge-warning badge-pill'>Applied</label>"
                    else if(row.status == "2")
                        return "<label class='badge badge-success badge-pill'>Admitted</label>"
                    else if(row.status == "3")
                        return "<label class='badge badge-danger badge-pill'>Expired</label>"
                    },
                name:'status'
                },
            ]
        });
        });
    </script>
@endsection
</x-app-layout>
