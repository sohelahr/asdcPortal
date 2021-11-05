<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>
        Identity Card Asdc
    </title>
    <style>
        @page{
            margin: 1%;
            padding: 0%;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
        }

        .card {
            width: 280px;
            height: 420px;
            padding: 15px;
            border-radius: 5px;
            margin: auto;
            text-align: center;
            align-content: center;
            align-items: center
        }

        .image {
            width: 60px;
            height: 80px;
            border: 5px solid #e1e1e1;
        }
        table{
            width: 260px;
            margin-top: 10px;
            margin-left: 20px
        }
        table tr td {
            margin: 0 auto;
            text-align: ;
        }

    </style>
</head>

<body>
    <div class="card">
        <div class="header">
            <img src = "{{url('/public/images/ASDC_Final_Logo-01.png')}}" width = "100px">
        </div>
        <img src = "{{asset('/storage/app/profile_photos/'.$data['photo'])}}" class="image">
        <h5>{{$data['name']}}</h5>

        <table style="align-self: center">
            <tr>
                <td><strong>Course</strong></td>
                <td>{{$data['course']}}</td>
            </tr>
            <tr>
                <td><strong>Roll No</strong></td>
                <td>{{$data['roll_no']}}</td>
            </tr>
            
            <tr>
                <td><strong>Batch</strong></td>
                <td>{{$data['batch']}}</td>
            </tr>
            <tr>
                <td><strong>DOB</strong></td>
                <td>{{$data['dob']}}</td>
            </tr>
            <tr>
                <td><strong>Contact</strong></td>
                <td>{{$data['mobile']}}</td>
            </tr>
        </table>
    </div>
</body>

</html>
