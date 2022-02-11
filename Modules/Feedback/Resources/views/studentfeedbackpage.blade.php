@extends('layouts.app')
@section('content')
    
    <div id="overlay-loader" class="d-none">
        <div style="height: 100%;width:100%;position: absolute;z-index:999;" class="d-flex justify-content-center align-items-center"> 
            <div> 
                <div class="loader-box">
                    <div class="loader-7"></div>
                </div>                             
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row justify-content-between">
                <div class="col-6">
                    <h3>My Feedbacks</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="email-wrap bookmark-wrap">
            <div class="row">
                
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="crm-activity" id="feedbacks">
                                
                            </ul>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>
@endsection    
@section('jcontent')
    <script>
        var baseurl = '{{url("/")}}'
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        
        function Notify(title,msg,status){
             $.notify({
                    title:title,
                    message:msg
                },
                {
                    type:status,
                    allow_dismiss:true,
                    newest_on_top:false ,
                    mouse_over:true,
                    showProgressbar:false,
                    spacing:10,
                    timer:2000,
                    placement:{
                        from:'top',
                        align:'center'
                    },
                    offset:{
                        x:30,
                        y:30
                    },
                    delay:1000 ,
                    z_index:10000,
                    animate:{
                        enter:'animated pulse',
                        exit:'animated bounce'
                    }
            });
        }
        @if(\Illuminate\Support\Facades\Session::has('profile_complete')) 
                Notify('Profile Complete','Please Contact admin to make changes to your profile','danger')   
            @elseif(\Illuminate\Support\Facades\Session::has('profile_not_complete'))
                Notify('Danger','First Update Your Profile','danger')   
            @elseif(\Illuminate\Support\Facades\Session::has('profile_updated'))
                Notify('success','Profile was successfully updated','success')   
            @elseif(\Illuminate\Support\Facades\Session::has('registered'))
                Notify('Registered','You have successfully registered For a course','success')   
                
            @elseif(\Illuminate\Support\Facades\Session::has('already_registered'))
                Notify('Warning','You have already registered for two courses please visit the center before applying for more','warning')   

             @elseif(\Illuminate\Support\Facades\Session::has('unauthorized'))
                Notify('Unauthorized','Aha! being sneeky af','danger')   
            @elseif(\Illuminate\Support\Facades\Session::has('feedback_created'))
                Notify('Success','Feedback was successfully recorded','success')   

            @elseif(\Illuminate\Support\Facades\Session::has('error'))
                Notify('Danger','Something went wrong ','danger')   
            @endif

        function getFeedbacks() {
            $.ajax({
                type: "get",
                url: `{{url("feedback/get-all-feedback-headers-per-admission/")}}`,
                beforeSend: function () {
                    $('#overlay-loader').removeClass('d-none');
                },
                success: function (response) {
                    $("#feedbacks").empty();
                    response = JSON.parse(response);
                    if(response.status == true){
                        if(response.data.length){

                            $.each(response.data, function (index, element) { 
                                $('#feedbacks').append(`
                                        <li class="media">
                                            <span class="me-3 overflow-hidden">
                                                <div class='initials text-capitalize'>
                                                    <span>${element.course_slug}</span>
                                                </div>
                                            </span>
                                            <div class="align-self-center media-body">
                                                <div class="d-flex flex-row align-items-center justify-content-between">
                                                    <div>
                                                        <h6 class="mt-0">
                                                            ${element.course} 
                                                        </h6>
                                                    </div>
                                                    ${(element.filled_status == 0 && element.header_status !== "2") ? (
                                                        `
                                                        <a href="${baseurl}/feedback/lines/create/${btoa(element.id)}/one">
                                                            <span style="font-size:24px" class="txt-primary">
                                                                <i class="icofont icofont-circled-right" ></i>
                                                            </span>
                                                        </a>`)
                                                    : ''}             
                                                </div>
                                                <ul class="dates">
                                                    <li>
                                                        <span class="text-dark">Your Response:</span>
                                                        <span class="text-${element.filled_status == 0 ? (element.header_status == "2" ? 'danger' : 'warning' ) : 'success'}">
                                                            ${element.filled_status == 0 ? (element.header_status == "2" ? 'Not Submitted' : 'Pending' ) : 'Submitted'}
                                                        </span>
                                                    </li>
                                                </ul>
                                                <ul class="dates">
                                                    <li><span class="text-dark">End Date:</span> ${element.end_date}</li>
                                                </ul>
                                                <ul class="dates">
                                                    <li>
                                                        <span class="text-dark">Status:</span> 
                                                        ${element.header_status  == '1' ? 'Active' : 
                                                            (element.header_status  == '2' ? 'Expired': 'Initialized' )
                                                        }
                                                    </li>
                                                </ul>
                                            </div>                
                                        </li>
                                `);
                            });
                        }
                        else{
                            $('#feedbacks').append(`
                                <h3>No feedbacks to fill yet :)</h3>
                            `);
                        }
                    }
                    else
                    {
                        $('#feedbacks').append(`
                            <h3>No feedbacks to fill yet :)</h3>
                        `);
                    }
                    $('#overlay-loader').hide();

                },
            });
            
        }
        
        
        $(document).ready(function () {
            getFeedbacks();
        }); 

        //Feedbacks assigned via sort wise
        
        /* $('#feedback_header_table').DataTable({
            processing: true,
            serverSide: true,
            searching:false,
            ordering:false,
            "pageLength": 30,
            "bDestroy": true,
            
            ajax: {
                "url":`{{url("feedback/get-all-feedback-headers-per-admission/")}}`,
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columnDefs": [
                {"class": "text-center", "targets": '_all'}
            ],
            columns: [
                {
                    data:'instructor',
                    name:'instructor'
                },
                {
                    data:'start_date',
                    name:'start_date'
                },
                {
                    data:'end_date',
                    name:'end_date'
                },
                {
                    data:'header_status',
                    render:function(data,type,row){
                        if(data == '1'){
                            return "<span>Active</span>"
                        }
                        else if(data == '2'){
                            return "<span>Expired</span>"
                        }
                        else{
                            return "<span>Initialized</span>"
                        }
                    },
                    name:'header_status'
                },
                {
                    data:'filled_status',
                    render:function(data,type,row){
                        if(data == 0){
                            if(row.header_status == '2'){
                                return "<span class='text-danger'>Not Submitted</span>"
                            }
                            return '<a href="feedback/lines/create/'+btoa(row.id)+'"><span class="text-warning">Pending</span></a>';
                        }
                        else{
                            return "<span class='text-success'> </span>"
                        }
                    },
                    name:'filled_status'
                },
            ]
        }); */
    

    </script>
@endsection