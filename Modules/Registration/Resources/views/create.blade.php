<x-app-layout>
    
    <x-slot name="header">
        <h5 class="font-semibold text-m text-gray-800 leading-tight">
            {{ __('Course Enrollment') }}
        </h5>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- <div class="mt-2 row justify-content-around">
                        <div class="col-4"> 
                            <form action="{{route('user_registration_create')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="course">Choose A Course</label>
                                    <select name="course_id" id="select-course" class="form-control">
                                        <option>Choose One</option>
                                        @foreach ($courses as $course)
                                            <option value="{{$course->id}}">{{$course->name}}</option>                                    
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="course-slot">Choose Available Slot</label>
                                    <select name="course_slot_id" id="select-course-slot" class="form-control">
                                        <option>First Choose A Course</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            </form>
                        </div>
                        <div class="col-4">
                            <div id="course-information">

                            </div>
                            <div id="courseslot-information">

                            </div>
                        </div>
                    </div> --}}
                    <div>
                        <table class="table table-hover" id="enrollment">
                        <thead>
                            <tr>
                                <th style="width: 30px">No</th>
                                <th>Course Name</th>
                                <th>Course Duration</th>
                                <th>Available Timings</th>
                                <th>Apply</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Course Name</th>
                                <th>Course Duration</th>
                                <th>Available Timings</th>
                                <th>Apply</th>                            
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table =  $('#enrollment').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{route('enrollmentData')}}",
                        columns:[
                            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                            {data: 'name',name:"name"},
                            {data: 'Duration',name:"duration"},
                            
                            {data: 'courseslot',render:function(data,type,row){
                                data = JSON.parse(data)
                                if(data.length){
                                    let options =  "<option value=''>Select a Slot</option>";

                                    data.forEach(element => {
                                            options += `<option value="${element.id}">${element.name}</option>` 
                                    });                                
                                    
                                    return `<select class="form-control" id="course-slot-${row.id}">
                                                ${options}
                                            </select>`
                                }
                                else
                                    return "Not Available"    
                                },
                            name:"course_slot"},
                    
                            {data: 'apply',
                                render:function(data,type,row){
                                    console.log(data)
                                    if(data=="false")
                                        return '<button class="badge badge-pill badge-info apply-button" onclick="ApplyForEnrollment('+row.id+')"  >Apply For this Course</button>';
                                    else
                                        return '<button class="badge badge-pill badge-warning" disabled>Already Applied</button>';
                                },
                            name:"apply"},
                        ]
                    });

                function ApplyForEnrollment(id) {
                    let courseslot = $("#course-slot-"+id).val();
                    data = {course_id:id,course_slot_id:courseslot}
                    if(courseslot == "")
                        swal({
                            title: "Warning",
                            text: "Please Select A Course Timing First",
                            icon: "warning",
                        });
                    else{

                        $.ajax({
                            type: "post",
                            url: "{{route('user_registration_create')}}",
                            data: data,
                            beforeSend: function () {
                                $('.apply-button').hide();
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
                                    $.toast({
                                        heading: 'Warning',
                                        text: response.msg,
                                        position:'top-center',
                                        icon: 'warning',
                                        loader: true,        // Change it to false to disable loader
                                        loaderBg: '#9EC600'
                                    });
                                    setTimeout(() => {
                                        window.location.href = "{{url('/dashboard')}}"
                                    },3000)
                                }
                                table.draw();
                            },
                        });
                    }
                }
        </script>
    @endsection
</x-app-layout>