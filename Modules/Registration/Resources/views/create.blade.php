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
                                <th style="width: 30px">No</th>
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
                        pageLength: 20,
                        processing: true,
                        serverSide: true,
                        ajax: "{{route('enrollmentData')}}",
                        columns:[
                            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                            {data: 'name',name:"name"},
                            {data: 'Duration',name:"duration"},
                            
                            {data: 'courseslot',render:function(data,type,row){
                                data = JSON.parse(data)
                        
                                if(data == true){
                                    return "<p class='ml-2'>Applied<p>"

                                }
                                else{
                                    
                                    let options =  "<option value=''>Select a Slot</option>";

                                    data.forEach(element => {
                                            options += `<option value="${element.id}">${element.name}</option>` 
                                    });                                
                                    
                                    return `<select class="form-control" id="course-slot-${row.id}">
                                                ${options}
                                            </select>`
                                }
                            },
                            name:"course_slot"},
                    
                            {data: 'apply',
                                render:function(data,type,row){
                                    if(data=="false")
                                        return '<button class="badge badge-pill badge-primary apply-button" onclick="ApplyForEnrollment('+row.id+')"  >Apply For this Course</button>';
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
                                $('.apply-button').attr("disable");
                                $('.apply-button').addClass('btn-inverse-info');
                                $('.apply-button').append(` <i class="fas fa-spinner  fa-spin"></i>`);
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
                                $('.apply-button').removeAttr("disable").removeClass('btn-disabled');
                            },
                        });
                    }
                }
        </script>
    @endsection
</x-app-layout>