<html lang="en">
<head>
    <title>Admission Form</title>
    <style>
        @media print {
            .pagebreak { page-break-after: always; } /* page-break-after works, as well */
            }
            table,th,td{
                /* border: 1px solid black; */
                font-size: 14px;
                vertical-align: middle;
            }
            td{
                padding: 2px;
            }
            p{
                padding: 0%;
                margin: 4px;
            }
            tr{
                vertical-align: middle;
                margin-top: 5px;
                margin-bottom:7px; 
                padding: 8px;
            }
        
    </style>
</head>
<body>
    <page size = "A4">
        <div style = "border: 1px solid red; border-top-left-radius: 20px; border-top-right-radius: 20px;">
        <table style = "width: 100%;" align="center">
            <tr>
                <td>
                    <div style=" top: 0%; margin-left: 10%; padding-top: 2%; width: 25%">
                        <img src = "{{url('/public/images/Seed_Logo3.png')}}" width = "80px" style = "padding-left: 30px">
                    </div>
                </td>
                <td style = "width: 55%;">
                    <img src = "{{url('/public/images/ASDC_Final_Logo-01.png')}}" width = "300px">
                </td>
                <td style = "width: 20%;">
                    <div style=" padding-left: 15%; padding-top: 3%;">
                        <img src = "{{url('/public/images/TQF Logo.jpg')}}" width = "100px">
                    </div>
                </td>
            </tr>
        </table>
        <div style = "text-align: center; background-color: rgb(226, 223, 223);font-size:12px">
            <p>1<sup>st</sup> floor, Near LEE Chinese Restaurant, Syed Ali Chabutra Shah Ali Banda Road, Hyderabad-65</p>
        </div>
        
                    <div>
                    <p style = "margin-top:100px; padding-left: 200px "><u>APPLICATION FORM FOR ADMISSION</u></p>
                    </div>
                
           
        
            <div style = "margin-top:-60px;margin-right:10px;">
                   <img src = "{{asset('/storage/app/profile_photos/'.$data['photo'])}}" alt = "" height = "100px" width = "100px" style = "float: right">
            </div>
        <div style="margin-top: 30px;margin:20px;">
            <table style = "width:100%">
                <tr>
                    <td width="90px">
                        <p>Name:</p>
                    </td>
                    <td   style="border-bottom: 1px solid black; padding-bottom: 0%;width:90%">
                            <p style = "padding-bottom: 0%; ">{{$data['name']}}</p>
                    </td>
                </tr>
            </table>
            <table style = "width:100%">
                <tr>
                    <td style="width: 15%">
                        <p>Date of Birth:</p>
                    </td>
                    <td style="border-bottom: 1px solid black; padding-bottom: 0%;width:15%">
                        <p style = "padding-bottom: 0;">{{$data['dob']}}</p>
                    </td>
                    <td style="width: 20%">
                            <p style="padding-left: 10px;">Gender:</p>
                    </td>
                    <td>
                        <div style="display: inline-block">
                            <input type = "radio" value = "male" @if ($data['gender'] == "male")
                                checked=""
                            @endif>Male
                            <input type = "radio" value = "female" @if ($data['gender'] == "female")
                                checked=""
                            @endif>Female
                        </div>
                    </td>
                <tr>
                    <td>
                        <p>Mobile No.:</p>
                    </td>
                    <td style="border-bottom: 1px solid black; padding-bottom: 0%;width:30%">
                            <p style = "padding-bottom: 0%; ">{{$data['mobile']}}</p>
                    </td>
                    <td>
                        <p  style="padding-left: 10px;">Adhaar No.:</p>
                    </td>
                    <td style="border-bottom: 1px solid black; padding-bottom: 0%;">
                            <p style = "padding-bottom: 0%; ">{{$data['aadhaar']}}</p>
                    </td>
                </tr>
                <tr>
                    <td >
                        <p>Qualification:</p>
                    </td>
                    <td style="border-bottom: 1px solid black; padding-bottom: 0%;width:40%">
                            <p style = "padding-bottom: 0%; ">{{$data['qualification']}}</p>
                    </td>
                    <td>
                        <p  style="padding-left: 10px;">Occupation:</p>
                    </td>
                    <td style="border-bottom: 1px solid black; padding-bottom: 0%;">
                            <p style = "padding-bottom: 0%; ">{{$data['occupation']}}</p>
                    </td>
                    
                </tr>
            </table>
            <table style = "width:100%">
                <tr>
                    <td style="width: 10%">
                        <p>Email:</p>
                    </td>
                    <td  style="border-bottom: 1px solid black; padding-bottom: 0%;width:90%">
                            <p style = "padding-bottom: 0%; ">{{$data['email']}}</p>
                    </td>
                </tr>
            </table>
            <table style = "width:100%">
                <tr>
                    <td style="width: 25%">
                        <p>School/College Name:</p>
                    </td>
                    <td  style="border-bottom: 1px solid black; padding-bottom: 0%;width:75%">
                            <p style = "padding-bottom: 0%; ">{{$data['school_name']}}</p>
                    </td>
                </tr>
            </table>
            <table style = "width:100%">
                <tr>
                    <td style="width: 20%">
                        <p>Father's Name:</p>
                    </td>
                    <td  style="border-bottom: 1px solid black; padding-bottom: 0%;width:80%">
                        <p style = "padding-bottom: 0%; ">{{$data['father_name']}}</p>
                    </td>
                </tr>
            </table>
            <table style = "width:100%">
                <tr>
                    <td style="width: 25%">
                        <p>Father's Occupation:</p>
                    </td>
                    <td style="border-bottom: 1px solid black; padding-bottom: 0%;width:25%">
                            <p style = "padding-bottom: 0%; ">{{$data['father_occupation']}}</p>
                    </td>
                    <td style="width: 20%">
                        <p  style="padding-left: 10px;">Fathers's Income:</p>
                    </td>
                    <td  style="width:35%;border-bottom: 1px solid black; padding-bottom: 0%;">
                            <p style = "padding-bottom: 0%; ">{{$data['fathers_income']}}</p>
                    </td>
                    
                </tr>
            </table>
            <table style = "width:100%">
                <tr>
                    <td style="width:20%">
                        <p>Father's Mobile:</p>
                    </td>
                    <td  style="border-bottom: 1px solid black; padding-bottom: 0%;width:80%">
                            <p style = "padding-bottom: 0%; ">{{$data['fathers_mobile']}}</p>
                    </td>
                </tr>
            </table>
            <table style = "width:100%">
                <tr>
                    <td style="width: 10%">
                        <p>Address: </p>
                    </td>
                    <td  style="border-bottom: 1px solid black; padding-bottom: 0%;width:90%">
                            <p style = "padding-bottom: 0%; ">{{$data['address']}}</p>
                    </td>
                </tr>
            </table>
            <table style = "width:100%">
                <tr>
                    <td style="width: 20%">
                        <p>Course Joining:</p>
                    </td>
                    <td style="border-bottom: 1px solid black; padding-bottom: 0%;width:30%">
                        <p style = "padding-bottom: 0%; ">{{$data['course']}}</p>
                    </td>
                    <td style="width: 25%">
                        <p style="padding-left: 10px;">Timing:</p>
                    </td>
                    <td style="border-bottom: 1px solid black; padding-bottom: 0%;width:25%">
                        {{$data['course_slot']}}
                    </td>
                    
                </tr>
            </table>
            <table style="width: 100%">
                <tr>
                    <td style="width: 20%">
                        <p>Attached:</p>
                    </td>
                    <td style="width:80%">
                        <div style="margin-left: 20px">
                       @foreach ($data['documents'] as $document)
                           <input type="checkbox" @if(in_array($document->id,$data['documents_submitted'])) checked=""  @endif>
                              {{$document->name}}
                       @endforeach
                        </div>
                   </td>
                </tr>
            </table>
            <table style="width: 100%;margin-top:10px;">
                <tr>
                    <td style="width: 10%">
                        <p>Date:</p>
                    </td>
                    <td style="width: 40%">
                        <div style = " padding-bottom: 0%;">
                            <p style = "padding-bottom: 0%;">{{$data['current_date']}}</p>
                        </div>
                    </td>
                    <td style="border-bottom: 1px solid black; padding-bottom: 0%;width:20%">
                        <p style = "padding-bottom: 0%; "></p>
                    </td>
                    <td style="width: 30%">
                        <p  style="padding-left: 10px;">Student Signature</p>
                    </td>
                </tr>                
            </table>
        </div>
        <div style = "background-color: rgb(226, 223, 223);">
            <div style="padding-bottom:2%">
            <p style = "text-align: center;padding-top: 10px;">FOR OFFICE USE ONLY</p>
            </div>
            <div style="padding-bottom:2%">
            <table style = "width:100%">
                <tr>
                    <td style = "width:20%">
                        <p>Admission Number:</p>
                    </td>
                    <td style="width: 80%">
                            <p style = "border-bottom: 1px solid black; padding-bottom: 0%;">{{$data['admission_number']}}</p>
                    </td>
                </tr>
            </table>
            <table style="width: 100%">
    
                <tr>
                    <td style="width: 20%">
                        <p>Remarks:</p>
                    </td>
                    <td style="width:80%;border-bottom: 1px solid black; padding-bottom: 0%;">
                            <p style = "padding-bottom: 0%; ">{{$data['admission_remarks']}}</p>
                    </td>
                </tr>
            </table>
            <table style="padding: 2%;width: 100%">
                <tr>
                    <td style = "padding-top: 50px;">
                        <p>Admin Signature</p>
                    </td>
                    <td></td>
                   <td></td>
                    <td style="padding-top: 50px;text-align: right">   <p >Director Signature</p>
                    </td>
                    
                </tr>
            </table>
            </div>
        </div>
        </div>
    </page>
    <div class="pagebreak"></div>
    
    <page>
        <div style = "padding: 2%;">
        <h2 style = "text-align: center;">COMPUTER LABORATORY RULES AND REGULATIONS</h2>

            <ol>
                <li>Smoking, chewing, eating and drinking are not allowed in the institiute building.</li>
                <li>Mobile Phones must be on silent flight modea at all times in the lab.</li>
                <li>Using Mobile is strictly prohibited in the institute Building.</li>
                <li>Do not change the settings on the computer.</li>
                <li>Students are not allowed to download or  print.</li>
                <li>The lab should be kept clean and tidy at all times, no food items are allowed in the lab.</li>
                <li>Do not attempt to repair or tamper with lab equipment.</li>
                <li>Do not move any equipment from its original position.</li>
                <li>Do not remove or load any software into the computer.</li>
                <li>Students are strictly adviced to take care of personal belongings all the time<br>The 
                institute is not responsible or liable for any lost belonging in the computer lab.</li>
                <li>Games are strictly prohibited on all the computer lab resources. Students running games will be asked to<br>
                close the game and leave the lab or the student ID will be confiscated to be reported to the Desciplinery Board.</li>
                <li>Students are requested to conduct themselves in a responsible and courteaous manner while in institute building.</li>
                <li>Do not bring bags in the lab</li>
                <li>Students are not allowed to bring any thumb drives, hard disks, USB, External HDD etc. Expenses will be recovered for
                    any loss or damage.
                </li>
                <li>Interned facility is strictly for educationsl purpose only.</li>
                <li>Students are not allowed to operate the air condition system.</li>
                <li>Students are not allowed to enter the lab without faculty instructor.</li>
                <li>Students are not allowed to open/unwscrew CPU, keyboard, mouse etc.</li>
                <li>Students are not allowed to argue with the faculty instructor.</li>
                <li>Students are not allowed to misbehave with sny of the staff member.</li>
                <li>The Computers in the labs are to be used for academic purposes only.</li>
                <li>All the Students are requested to come to the institute decently dressed and with a decent hairstyle.</li>
                <li>The Institute upholds that bulling or harrassment of any student or employee is prohibited.</li>
                <li>Wear mask, inform faculty if having fever, cough etc.</li>
            </ol>
            <p style = "padding-top: 3%;">Note: Violoation of these rules will result in immediate suspension of admission. Strict action will be taken against any misbehaviour and damage will be reovered from the student. </p>
            <div style = "padding-top: 5%;">
                <p style="text-align: right;">Student Signature</p>
            </div>
        </div>
    </page>
    <div class="pagebreak"></div>
    <page>
        <div style = "border: 1px solid black">
            <table style = "width: 100%;" align="center">
                <tr>
                    <td>
                        <div style=" top: 0%; margin-left: 10%; padding-top: 2%; width: 25%">
                            <img src = "{{url('/public/images/Seed_Logo3.png')}}" width = "80px" style = "padding-left: 30px">
                        </div>
                    </td>
                    <td style = "width: 55%;">
                        <img src = "{{url('/public/images/ASDC_Final_Logo-01.png')}}" width = "300px">
                    </td>
                    <td style = "width: 20%;">
                        <div style=" padding-left: 15%; padding-top: 3%;">
                            <img src = "{{url('/public/images/TQF Logo.jpg')}}" width = "100px">
                        </div>
                    </td>
                </tr>
            </table> 
            <div style = "text-align: center; background-color: rgb(226, 223, 223);font-size:12px">
                <p>1<sup>st</sup> floor, Near LEE Chinese Restaurant, Syed Ali Chabutra Shah Ali Banda Road, Hyderabad-65</p>
            </div>
            <div>
                <h4 style = "text-align: center"><u>ACKNOWLEDGEMENT OF CERTIFICATE RECEIVED</u></h4>
                <h5 style = "text-align: center;"><u>Student's Copy</u></h5>
            </div>
            <div style = "margin:10px;">
                <table style = "width:100%">
                    <tr>
                        <td  style = "width:20%">
                            <p>Name:</p>
                        </td>
                        <td   style="width:80%;border-bottom: 1px solid black; padding-bottom: 0%;">
                                <p style = "padding-bottom: 0%; ">{{$data['name']}}</p>
                        </td>
                    </tr>
                </table>
                <table style = "width:100%">
                    <tr>
                        <td style="width: 20%">
                            <p>Mobile No.:</p>
                        </td>
                        <td style="width:30%;border-bottom: 1px solid black; padding-bottom: 0%;">
                                <p style = "padding-bottom: 0%; ">{{$data['mobile']}}</p>
                        </td>
                        <td style="width: 20%">
                            <p  style="padding-left: 10px;">Admission No.:</p>
                        </td>
                        <td style="width:30%;border-bottom: 1px solid black; padding-bottom: 0%;">
                                <p style = "padding-bottom: 0%; ">{{$data['admission_number']}}</p>
                        </td>
                    </tr>
                </table>
                <table style = "width:100%">
                    <tr>
                        <td style="width: 20%">
                            <p>Course Applied:</p>
                        </td>
                        <td   style="width:70%;border-bottom: 1px solid black; padding-bottom: 0%;">
                                <p style = "padding-bottom: 0%; ">{{$data['course']}}</p>
                        </td>
                    </tr>
                </table>
                <table style = "width:100%">
                    <tr >
                        <td style="width: 20%">
                            <p>Original Certificate Submitted:</p>
                        </td>
                        <td   style="width:70%;border-bottom: 1px solid black; padding-bottom: 0%;">
                                <p style = "padding-bottom: 0%; ">@foreach ($data['documents'] as $document)
                                {{$document->name}} 
                            @endforeach</p>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td style = "padding-top: 70px; text-align: center">
                            <p><b>Student Signature</b></p>
                        </td>
                        <td style = "padding-top: 70px; text-align: right">
                            <p><b>Admin Signature</b></p>
                        </td>
                        <td style = "padding-top: 70px; text-align: center" colspan = "2">
                            <p><b>Director Signature</b></p>
                        </td>
                    </tr>
                </table>
                <table>
                <tr>
                    <td style="text-align: center"> 
                        <p>Note:This acknowledgement is compulsory at the time of withdrawal of original certificate. </p>
                    </td>
                </tr>
                </table>
            </div>
        </div>
        <div style = "border: 1px solid black; margin-top: 50px">
            <table style = "width: 100%;" align="center">
                <tr>
                    <td>
                        <div style=" top: 0%; margin-left: 10%; padding-top: 2%; width: 25%">
                            <img src = "{{url('/public/images/Seed_Logo3.png')}}" width = "80px" style = "padding-left: 30px">
                        </div>
                    </td>
                    <td style = "width: 55%;">
                        <img src = "{{url('/public/images/ASDC_Final_Logo-01.png')}}" width = "300px">
                    </td>
                    <td style = "width: 20%;">
                        <div style=" padding-left: 15%; padding-top: 3%;">
                            <img src = "{{url('/public/images/TQF Logo.jpg')}}" width = "100px">
                        </div>
                    </td>
                </tr>
            </table> 
            <div style = "text-align: center; background-color: rgb(226, 223, 223);font-size:12px">
                <p>1<sup>st</sup> floor, Near LEE Chinese Restaurant, Syed Ali Chabutra Shah Ali Banda Road, Hyderabad-65</p>
            </div>
            <div>
                <h4 style = "text-align: center"><u>ACKNOWLEDGEMENT OF CERTIFICATE RECEIVED</u></h4>
                
            </div>
            
            <div style = "margin:10px;">
                <table style = "width:100%">
                    <tr>
                        <td  style = "width:20%">
                            <p>Name:</p>
                        </td>
                        <td   style="width:80%;border-bottom: 1px solid black; padding-bottom: 0%;">
                                <p style = "padding-bottom: 0%; ">{{$data['name']}}</p>
                        </td>
                    </tr>
                </table>
                <table style = "width:100%">
                    <tr>
                        <td style="width: 20%">
                            <p>Mobile No.:</p>
                        </td>
                        <td style="width:30%;border-bottom: 1px solid black; padding-bottom: 0%;">
                                <p style = "padding-bottom: 0%; ">{{$data['mobile']}}</p>
                        </td>
                        <td style="width: 20%">
                            <p  style="padding-left: 10px;">Admission No.:</p>
                        </td>
                        <td style="width:30%;border-bottom: 1px solid black; padding-bottom: 0%;">
                                <p style = "padding-bottom: 0%; ">{{$data['admission_number']}}</p>
                        </td>
                    </tr>
                </table>
                <table style = "width:100%">
                    <tr>
                        <td style="width: 20%">
                            <p>Course Applied:</p>
                        </td>
                        <td   style="width:70%;border-bottom: 1px solid black; padding-bottom: 0%;">
                                <p style = "padding-bottom: 0%; ">{{$data['course']}}</p>
                        </td>
                    </tr>
                </table>
                <table style = "width:100%">
                    <tr >
                        <td style="width: 20%">
                            <p>Original Certificate Submitted:</p>
                        </td>
                        <td   style="width:70%;border-bottom: 1px solid black; padding-bottom: 0%;">
                                <p style = "padding-bottom: 0%; ">@foreach ($data['documents'] as $document)
                                {{$document->name}} 
                            @endforeach</p>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td style = "padding-top: 70px; text-align: center">
                            <p><b>Student Signature</b></p>
                        </td>
                        <td style = "padding-top: 70px; text-align: right">
                            <p><b>Admin Signature</b></p>
                        </td>
                        <td style = "padding-top: 70px; text-align: center" colspan = "2">
                            <p><b>Director Signature</b></p>
                        </td>
                    </tr>
                </table>        
            </div>
        </div>
    </page>
</body>
</html>