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
                    <div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    @section('jcontent')
        <script>
            $(document).ready(function () {
             $('#admission_form').validate({
                errorClass: "text-danger pt-1",            
                rules: {     
                    course_id: {
                        required: true,
                    },
                    coursebatch_id: {
                        required: true,
                    },
                    course_slot_id: {
                        required: true,
                    },
                    admission_remarks: {
                        required: true,
                    },  
                },
                messages: {
                    course_id: {
                        required: "Course is required",
                    },
                    coursebatch_id: {
                        required: "Please select a batch",
                    },
                    course_slot_id: {
                        required: "Please select a timing",
                    },
                    admission_remarks: {
                        required: "Please enter a remarks",
                    },  
                } 
            });
    }); 
            $("#registration_course").on('change',function(){
                let course_id = $("#registration_course").val()
                $.ajax({
                    type: "get",
                    url: `{{url('admission/getforminputs/${course_id}')}}`,
                    beforeSend: function() {
                    $('#overlay-loader').removeClass('d-none');
                            $('#overlay-loader').show();
                    },
                    success: function (response) {
                        console.log(response)
                        $("#course_slot").empty();
                        $("#course_batch").empty();

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
                        if(response.course_batches.length > 0){
                            $.each(response.course_batches, function (index, element) {
                                
                                    $("#course_batch").append(`
                                        <option value="${element.id}">${element.batch_number}</option>
                                    `);
                            });
                        }
                        else
                        {
                            $("#course_batch").append(`
                                    <option value="">Not Found</option>
                                `);
                        }
                    },
                    complete: function () {
                            $('#overlay-loader').hide();
                        },
                });
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
                                $('#overlay-loader').removeClass('d-none');
                                $('#overlay-loader').show();
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
                                $('#overlay-loader').hide();
                            },
                        });
                    }
                }
        </script>
    @endsection
</x-app-layout>