<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet"> 
    <title>asdc</title>
</head>
<style>
    @media (max-width:500px){
        .tqf{
            width: 40px!important;
        }
        .seed{
            width: 40px!important;
        }
        .logo{
            width: 100px!important;
        }
    }
</style>
<body>
    <div style = "background-color: #1c4f46; height: 100px">

    </div>
    <div class = "container">
        <div style = " box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; margin-top: -30px; background-color: white; margin-left: 5%; margin-right: 5%;">
            <div>
                <table style = "width: 100%;padding:3%">
                    <td style = "width:20%">
                        <img src = "{{url('/public/images/Seed_Logo3.png')}}" width = "80px" style = "padding: 4%;" class="seed" />
                    </td>        
                    <td style = "text-align:center;width:60%;">
                        <img src = "{{url('/public/images/ASDC_Final_Logo-01.png')}}" width="275px" class="logo" />
                    </td>
                    <td style = "text-align: right;width:20%" class = "tqf">
                        <img src = "{{url('/public/images/TQF_Logo.jpg')}}" class = "tqf" width = "80px" style = "padding: 4%; " />
                    </td>
                 </table>
                <div>
                    <div style = "padding: 1% 0 0 5%">
                        <p style="text-transform: capitalize">Dear {{$content}}, </p>
                        <p><b>Greetings from ASDC,</b></p>
                        <p>ASDC is formed to help the students who could not continue their education with the required skills necessary for employment.</p>
                    </div>
                    <div style = "margin-top: 20px; text-align: center; padding: 2% 5%">
                        <p>Verify your email by pressing below, by pressing the button below,</p>
                    </div>
                    <div style = "text-align: center;margin-bottom:1%">
                        <a href="{{route('verify_mail',base64_encode($user_id))}}"><button style = "background-color: #1c4f46 ; border: 1px solid rgb(54, 14, 54); border-radius: 10px; color: white; width: 80px; height: 40px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;">Click Here</button>
                    </div>
                    <div style="margin:4%;text-align: center;padding-bottom:4%">
                        Click <a href="{{route('verify_mail',base64_encode($user_id))}}">here</a> if the button doesn't work.
                    </div>
                    {{-- <div style = "width: 100%">
                        <div style = "display: inline-block; padding: 3%">
                            <img src = "{{url('/public/images/Seed_Logo3.png')}}" width = "100px" style = "padding: 4%;" />
                        </div>
                        <div style = "float: right; display: inline-block; padding: 3%; margin-top: 20px;" class = "tqf">
                            <img src = "{{url('/public/images/TQF_Logo.jpg')}}" class = "tqf" width = "100px" style = "padding: 4%; " />
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <div style = " box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; background-color: white; margin-left: 5%; margin-right: 5%;">
            <div class = "contact">
                <div>
                    <p style = "text-align: center; margin-top: 2%; padding-top: 2%;">Contact Us</p>
                    <hr  style = "text-align: center; margin-left: 4%; margin-right: 4%;">
                </div>
                <div style = "text-align: center; padding: 3%;">
                    <div style = "text-align: center; padding: 3%;">
                    <div>
                        <p><i class = "fa fa-home"></i><b>&nbsp;Address:</b> 1st floor, Above LEE Chinese Restaurant, Shah Ali Banda Road, Hyderabad</p>
                    </div>
                    <div>
                        <p><i class = "fa fa-phone"></i><b>&nbsp;Phone:</b> +91 7207084178</p>
                    </div>
                    <div>
                        <p><i class = "fa fa-envelope"></i><b>&nbsp;Email:</b> contact@asdc-india.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>