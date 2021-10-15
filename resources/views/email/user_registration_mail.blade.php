<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    
    <title>asdc</title>
</head>
<style>
    @media (max-width: 768px){
        .tqf{
            margin-left: 200px !important;
        }
    }
</style>
<body>
    <div style = "background-color: #392C70; height: 100px">

    </div>
    <div class = "container">
        <div class="card-body bg-white" style = " box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; margin-top: -30px;">
            <div class = "row">
                <div class = "col-md-12 text-center">
                    <img src = "{{url('/public/images/ASDC_Final_Logo-01.png')}}" class = "img-fluid" width = "300px" />
                </div>
                <div class = "container">
                    <div class = "col-md-8">
                        <p>Dear {{$content}}, </p><br>
                        <p><b>Greetings from ASDC, (Tag line comes here!)</b></p>
                        <p>ASDC is formed to help the students who could not continue their education with the required skills necessary for employment.</p>
                    </div>
                    <div class = "col-md-12 text-center" style = "margin-top: 200px;">
                        <p>By pressing the button below, please let us know something something.....</p>
                    </div>
                    <div class = "col-md-12 text-center">
                        <button style = "background-color: rgb(54, 14, 54); border: 1px solid rgb(54, 14, 54); border-radius: 10px; color: white; width: 200px; height: 50px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;">Click Here</button>
                    </div>
                    <div class = "d-flex">
                        <div class = "col-md-6">
                            <img src = "{{url('/public/images/Seed_Logo3.png')}}" class = "img-fluid" width = "100px" />
                        </div>
                        <div class = "col-md-6">
                            <img src = "{{url('/public/images/TQF Logo.jpg')}}" class = "img-fluid tqf" width = "100px" style = "float: right; margin-top: 20px;" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div  class="card-body bg-white mb-4" style = " box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; margin-top: 20px;">
            <div class = "container">
                <div class = "col-md-12 text-center">
                    <p>Contact Us</p>
                    <hr>
                </div>
                <div class = "row">
                    <div class = "col-md-4 text-center">
                        <p><i class = "fa fa-home"></i><b>&nbsp;Address:</b></p>
                        <p>1st floor, Above LEE Chinese Restaurant, Shah Ali Banda Road, Hyderabad</p>
                    </div>
                    <div class = "col-md-4 text-center">
                        <p><i class = "fa fa-phone"></i><b>&nbsp;Phone:</b></p>
                        <p>+91 7207084178</p>
                    </div>
                    <div class = "col-md-4 text-center">
                        <p><i class = "fa fa-envelope"></i><b>&nbsp;Email:</b></p>
                        <p>contact@asdc-india.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>