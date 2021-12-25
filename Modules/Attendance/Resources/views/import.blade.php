@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Attendance Imports
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{url('attendance')}}">Attendance</a></li>
            <li class="breadcrumb-item active" aria-current="page">Attendance Import</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div id="overlay-loader" class="d-none">
            <div style="height: 100%;width:100%;background:rgba(121, 121, 121, 0.11);position: absolute;z-index:999;" class="d-flex justify-content-center align-items-center"> 
                <div >  
                    
                        <div class="dot-opacity-loader">
                            <span></span>
                            <span></span>
                            <span></span>
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
                                class="form-control-file" 
                                id="uploaded_file"
                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                required
                            >
                        </div>
                        <button type="button" class="btn btn-outline-primary mx-2" id="but_upload" onclick="uploadFile(this);">Import</button>
                        <button type="submit" class="btn btn-outline-success" id="publish_butt" onclick="showLoader();" disabled>Publish</button>
                        <a type="button" class="btn btn-outline-danger mx-2"  onclick="showLoader();" href="{{route('abort_attendance')}}">Abort</a>
                    </form>    
                </div>
            </div>
            <hr>
            <div class="row d-none p-4" id="preview-records">
                <h1 class="card-title">Preview Data</h1>
                    <table class="table table-hover" id="dumpedtable">
                        <thead>
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
                        <tbody>
                        </tbody>
                    </table>
            </div>
        </div>
        
    </div>
    
@endsection
@section('jcontent')
    <script>
        function showLoader(){
            $('#overlay-loader').removeClass('d-none');
            $('#overlay-loader').show();
        }
        @if(\Illuminate\ Support\ Facades\ Session::has('aborted'))
            $.toast({
                heading: 'Aborted',
                text: 'Attendance Import was Aborted',
                position: 'top-right',
                icon: 'info',
                loader: true, // Change it to false to disable loader
                loaderBg: '#9EC600' // To change the background
            })

        @elseif(\Illuminate\ Support\ Facades\ Session::has('error'))
            $.toast({
                heading: 'Danger',
                text: 'Something Went Wrong ',
                position: 'top-right',
                icon: 'danger',
                loader: true, // Change it to false to disable loader
                loaderBg: '#9EC600' // To change the background
            })
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
                       $.toast({
                            heading: 'Success',
                            text: response.message,
                            position:'top-right',
                            icon: 'success',
                            loader: true,        // Change it to false to disable loader
                            loaderBg: '#9EC600'  // To change the background
                        })
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