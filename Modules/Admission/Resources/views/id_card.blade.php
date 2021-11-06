<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Identity Card Asdc
    </title>
    <style>
        @page{
            margin: 0%;
            padding: 0%;
        }
        @media print {
            .pagebreak { page-break-after: always; } /* page-break-after works, as well */
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            font-size: 8px;
            color: #073147;
        }

        .card {
            text-align: center;
            align-content: center;
            align-items: center
        }

        .image {
            width: 60px;
            height: 80px;
            border-radius: 12px;
            border: 1px solid #618c9f;
        }
        .header{
            margin-top: 120px;
        }
        table{
            width: 90%;
            margin-top: 40px;
            margin-left: 20px;
            margin-bottom: 10px;
            border-collapse: collapse
        }
        tr td {
            margin: 0 auto;
            text-align: left;
            margin-bottom:2px; 
            border-bottom: 1px solid #2c525b ;
        }

    </style>
</head>

<body>
    <img src = "{{url('/public/images/id_Card_top.svg')}}" width = "100px">
    <div class="card">
        <div class="header">
            <img src = "{{url('/public/images/ASDC_Final_Logo-01.png')}}" width = "100px">
        </div>
        <div style="margin-bottom: -30px;z-index:999">
            <img src = "{{asset('/storage/app/profile_photos/'.$data['photo'])}}" class="image">
            <h5>{{$data['name']}}</h5>
        </div>
        <div style="bottom:5;background-color: #d6e9f0;width:100%;">
            <table>
                <tr>
                    <td style="color: #2c525b">Course Name:</td>
                    <td><strong>{{$data['course']}}</strong></td>
                </tr>
                <tr>
                    <td style="color: #2c525b">Roll No.:</td>
                    <td><strong>{{$data['roll_no']}}</strong></td>
                </tr>
                
                <tr style="color: #2c525b">
                    <td>Batch:</td>
                    <td><strong>{{$data['batch']}}</strong></td>
                </tr>
                {{--<tr>
                    <td>DOB</td>
                    <td>{{$data['dob']}}</td>
                </tr>
                <tr>
                    <td>Contact</td>
                    <td>{{$data['mobile']}}</td>
                </tr> --}}
            </table>
        </div>
    </div>
    <div style="width:100%;height: 5px;background-color:red;position:fixed;bottom:0;"></div>
    <div class="pagebreak"></div>
</body>

</html>
