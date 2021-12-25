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
            overflow: hidden!important;
            margin-left: 60px;
            width: 80px;
            height: 90px;/* 
            border-radius: 8px; */
            border: 1px solid #618c9f;
            margin-bottom: -30px;z-index:999;
        }
        .header{
            margin-top: -10px;
            margin-bottom:5px;
        }
        table{
            width: 80%;
            margin-left: 40px;
            border-collapse: collapse
        }
        td{
            border-bottom: 1px solid #2c525b ;
        }
        tr td {
            font-size: 7px;
            margin: 0 auto;
            text-align: left;
            margin-bottom:2px; 
        }

    </style>
</head>

<body>
    <img src = "{{url('/public/images/id-card-top.png')}}">
    <div class="card">
        <div class="header">
            <img src = "{{url('/public/images/ASDC_Final_Logo-01.png')}}" width = "150px">
        </div>
        <div style="margin: auto;text-align:center;">
            <div class="image">
                @if($data['photo'])
                <img src = "{{asset('/storage/app/profile_photos/'.$data['photo'])}}" width= "80px" height="90px">
                @else
                    <img src = "{{asset('/storage/app/profile_photos/blankimage.png')}}" alt = "" height = "80px" width = "90px">
                @endif
            </div>
            <h2>{{$data['name']}}</h2>
        </div>
        <div style="margin-top:-90px;padding-top:90px;padding-bottom:17px;background-color: #d6e9f0;width:100%;text-align:center">
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


    {{-- Second page --}}
    <img src = "{{url('/public/images/id-card-top.png')}}">
    <div class="card">
        <div class="header">
            <p style="font-size: 8px;letter-spacing:1px">If found please return to:</p>
            <img src = "{{url('/public/images/ASDC_Final_Logo-01.png')}}" width = "150px">
        </div>
        <div style="padding:20px 5px;background-color: #d6e9f0;width:100%;text-align:center;line-height:3px">
            <h2>#23-5-392, 1<sup>st</sup> Floor,</h2>
            <h2>Above LEE's Chinese </h2><h2> Restaurant,</h2>
            <h2>Shah Ali Banda Road, Hyd.</h2>
            <h2>Ph: +91 7207084178</h2>
            <div style="margin-top:20px">
                <h2>www.asdc-india.com</h2>
            </div>
        </div>
    </div>
    <div style="width:100%;height: 5px;background-color:red;position:fixed;bottom:0;"></div>


</body>

</html>
