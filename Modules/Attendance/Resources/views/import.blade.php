@extends('layouts.admin.app')
@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Attendance Imports</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('attendance')}}">Attendance</a></li>
            <li class="breadcrumb-item active" aria-current="page">Attendance Import</li>
    @endcomponent
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div id="overlay-loader" class="d-none">
                    <div style="height: 100%;width:100%;position: absolute;z-index:999;" class="d-flex justify-content-center align-items-center"> 
                        <div> 
                            <div class="loader-box">
                                <div class="loader-7"></div>
                            </div>              
                        </div>
                    </div>
                </div>
                <div class="my-5 px-3">
                    
                    <div class="row">
                        <div class="col-10">
                            <form action="{{route('publish_attendance')}}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center" id="attendanceform">
                                @csrf
                                <div class="mx-4">
                                    <input type="file" name="uploaded_file" 
                                        class="form-control" 
                                        id="uploaded_file"
                                        accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                        required
                                    >
                                </div>
                                <button type="button" class="btn btn-outline-primary mx-2" id="but_upload" onclick="uploadFile(this);">Import</button>
                                <button type="submit" class="btn btn-outline-success" id="publish_butt" onclick="showLoader();" disabled>Publish</button>
                                <a type="button" class="btn btn-outline-danger mx-2"  onclick="showLoader();" href="{{route('abort_attendance')}}" >Abort</a>
                            </form>    
                        </div>
                    </div>
                    <hr>
                    <div class="row d-none p-4" id="preview-records">
                        <h1 class="card-title">Preview Data</h1>
                            <table class="display datatables" id="dumpedtable">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>Date</th>
                                        <th>Roll no.</th>
                                        <th>Student Name</th>
                                        <th>Course</th>
                                        <th>Status</th>
                                        <th>Punch Records</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                            </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('jcontent')
    <script>
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
        function showLoader(){
            $('#overlay-loader').removeClass('d-none');
            $('#overlay-loader').show();
        }
        @if(\Illuminate\ Support\ Facades\ Session::has('aborted'))
            Notify('Aborted','Attendance Import was Aborted','info')
        @elseif(\Illuminate\ Support\ Facades\ Session::has('error'))
            Notify('Danger','Something went wrong','danger')
        @endif
        /* showPreview(); */
        function uploadFile(_this){
            var formData = new FormData($('#attendanceform')[0]);
            //formData.append( 'file', input.files[0] );
            $.ajax({
                url: `{{route('dump_attendance')}}`,
                type: "post",
                processData: false,
                contentType: false,
                dataType: 'JSON',
                data: formData,
                beforeSend: function() {
                $('#overlay-loader').removeClass('d-none');
                        $('#overlay-loader').show();
                $('#preview-records').hide();
                },
                success: function (response) {
                    console.log(response)
                    if (response.status === "1")
                    {
                        Notify('Success',response.message,'success')
                        $("#publish_butt").prop('disabled',false);
                        showPreview();
                    }
                    else
                    {
                        swal({
                            title: 'Warning',
                            text: response.message,
                            allowOutsideClick: false,
                            icon: 'error',
                        });
                    }
                },
                complete: function () {
                    $('#overlay-loader').hide();
                },
            });
        }

    function showPreview() {
        $("but_upload").prop('disabled', "true");
        $('#dumpedtable').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            searching: false,
            "autoWidth": false,
            "responsive": true,
            ajax: {    
                "url": "{{route('preview_attendance')}}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }],
            columns:[
                {data: 'Date', name: 'Date'},
                {data: 'EmployeeCode', name: 'EmployeeCode'},
                {data: 'EmployeeName',name:"EmployeeName"},
                {data: 'Department',name:"Department"},
                {data: 'Status',name:"Status"},
                {data: 'PunchRecords',name:"PunchRecords"},
            ]
        });
        $('#preview-records').removeClass('d-none');
        $('#preview-records').show();
    }

    </script>
@endsection