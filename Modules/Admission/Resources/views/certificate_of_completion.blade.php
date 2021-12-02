<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Course Completion Certificate</title>
    <style>
        @page {
            background: url('{{url('/public/images/course_completion_certificate.png')}}') no-repeat 0 0;
            background-image-resize: 6;
        }
        body{
            font-family:'poppins',sans-serif;
        }
        h2,h1{
            font-family: 'acme', sans-serif;
        }
    </style>
</head>
<body>
    <page>
        <div style="position: absolute;top:375;left:210;width:350px;text-align:center; ">
            <h2>{{$data['name']}}</h2>
        </div>
        <div style="position: absolute;top:375;right:110;width:300px;text-align:center; ">
            <h2>{{$data['father_name']}}</h2>
        </div>
        <div style="position: absolute;bottom:280;right:360;width:410px;text-align:center; ">
            <h1>{{$data['course']}}</h1>
        </div>
        <div style="position: absolute;bottom:235;right:420">
            <h2>{{$data['batch_start_date']}}</h2>
        </div>
        <div style="position: absolute;bottom:235;right:210">
            <h2>{{$data['batch_end_date']}}</h2>
        </div>
        <div style="position: absolute;bottom:185;right:390">
            <h2>{{$data['grade']}}</h2>
        </div>
        <div style="position: absolute;bottom:110;left:65;width:240px;text-align:center; ">
            <h2>{{$data['roll_number']}}</h2>
        </div>
        <div style="position: absolute;bottom:110;right:65;width:240px;text-align:center;">
            <img src="{{url('/public/images/signatures/asdc-director.png')}}" style="transform:rotate(-20deg)" alt="Director Signature" height="80" width="120px">
        </div>
    </page>
</body>
</html>