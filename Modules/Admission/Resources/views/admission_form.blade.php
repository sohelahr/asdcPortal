<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>Document</title>
    <style>
        @media print {
            .pagebreak { page-break-before: always; } /* page-break-after works, as well */
            }
    </style>
</head>
<body style = " font-size: 12px;">
    <page size = "A4" style = "padding: 2%;">
        <div style = "border: 1px solid red; border-top-left-radius: 20px; border-top-right-radius: 20px;">
        <header style = "width: 100%; ">
            <div style = "width: 30%; top: 0%; padding-left: 5%;padding-top: 2%;">
                <img src = "{{url('/public/images/Seed_Logo3.png')}}" width = "80px">
            </div>
            <div style = "width: 40%;  padding-left: 5%;">
                <img src = "{{url('/public/images/ASDC_Final_Logo-01.png')}}" width = "300px">
            </div>
            <div style = "width: 30%; padding-left: 10%; padding-top: 3%;">
                <img src = "{{url('/public/images/TQF Logo.jpg')}}" width = "100px" style="margin-top: 1%;">
            </div>
        </header>
        <div style = "text-align: center; background-color: rgb(226, 223, 223);">
            <p>1<sup>st</sup> floor, Near LEE Chinese Restaurant, Syed Ali Chabutra Shah Ali Banda Road, Hyderabad-65</p>
        </div>
        <div style = "">
            <div style = "width:70%">
               <p style = "text-align: right; margin-top: 10%; padding-right: 5%;"><u>APPLICATION FORM FOR ADMISSION</u></p>
            </div>
            <div style = "width:30%">
               <img src = "{{asset('/storage/app/profile_photos/'.$admission->Student->UserProfile->photo)}}" alt = "" height = "100px" width = "100px" style = "padding-left: 30%;">
            </div>
        </div>
        <div style = " padding: 5%; margin-top: -2%;">
            <div style = " font-size: 14px">
                <div style = "width: 20%;">
                    <p>Name:</p>
                </div>
                <div style = "width: 80%;">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">Hamza</p>
                    </div>
                </div>
            </div>
            <div style = " font-size: 14px; margin-top: -2%;">
                <div style = "width: 20%;">
                    <p>Date of Birth:</p>
                </div>
                <div style = "width: 20%">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">29/12/2021</p>
                    </div>
                </div>
                <div style = "width: 20%">
                    <p style="padding-left: 10px;">Gender:</p>
                </div>
                <div style = " width: 40%;">
                    <form style = "margin-top: 5%;">
                        <input type = "radio" value = "male">
                        <label>Male</label>
                        <input type = "radio" value = "female">
                        <label>Female</label>
                    </form>
                </div>
                
            </div>
            <div style = " font-size: 14px; margin-top: -2%;">
                <div style = "width: 20%;">
                    <p>Mobile No.:</p>
                </div>
                <div style = "width: 30%">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">9604195840</p>
                    </div>
                </div>
                <div style = "width: 20%;">
                    <p  style="padding-left: 10px;">Adhaar No.:</p>
                </div>
                <div style = "width: 30%">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">123456789012</p>
                    </div>
                </div>
                
            </div>
            <div style = " font-size: 14px; margin-top: -2%;">
                <div style = "width: 20%;">
                    <p>Qualification:</p>
                </div>
                <div style = "width: 30%">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">BCA Graduate</p>
                    </div>
                </div>
                <div style = "width: 20%;">
                    <p  style="padding-left: 10px;">Occupation:</p>
                </div>
                <div style = "width: 30%">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">Web Developer</p>
                    </div>
                </div>
                
            </div>
            <div style = " font-size: 14px;  margin-top: -2%;">
                <div style = "width: 20%;">
                    <p>Email:</p>
                </div>
                <div style = "width: 80%;">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">shaikhhamzasaleem960@gmail.com</p>
                    </div>
                </div>
            </div>
            <div style = " font-size: 14px;  margin-top: -2%;">
                <div style = "width: 30%;">
                    <p>School/College Name:</p>
                </div>
                <div style = "width: 70%;">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">Abeda Inamdar Senior College</p>
                    </div>
                </div>
            </div>
            <div style = " font-size: 14px;  margin-top: -2%;">
                <div style = "width: 20%;">
                    <p>Father's Name:</p>
                </div>
                <div style = "width: 80%;">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">Saleem Shaikh</p>
                    </div>
                </div>
            </div>
            <div style = " font-size: 14px; margin-top: -2%;">
                <div style = "width: 20%;">
                    <p>Father's Occupation:</p>
                </div>
                <div style = "width: 30%">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">Civil Engineer</p>
                    </div>
                </div>
                <div style = "width: 20%;">
                    <p  style="padding-left: 10px;">Fathers's Income:</p>
                </div>
                <div style = "width: 30%">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">10 LPA</p>
                    </div>
                </div>
                
            </div>
            <div style = " font-size: 14px;  margin-top: -2%;">
                <div style = "width: 20%;">
                    <p>Father's Mobile:</p>
                </div>
                <div style = "width: 80%;">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">9890851007</p>
                    </div>
                </div>
            </div>
            <div style = " font-size: 14px;  margin-top: -2%;">
                <div style = "width: 20%;">
                    <p>Address: </p>
                </div>
                <div style = "width: 80%;">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">102, DSK Garden Enclave Society, Parge Nagar, Kondhwa-42</p>
                    </div>
                </div>
            </div>
            <div style = " font-size: 14px;  margin-top: -2%;">
                <div style = "width: 20%;">
                    <p style = "color: white;">Address: </p>
                </div>
                <div style = "width: 80%;">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%; color: white;">102, DSK Garden Enclave Society, Parge Nagar, Kondhwa-42</p>
                    </div>
                </div>
            </div>
            <div style = " font-size: 14px; margin-top: -2%;">
                <div style = "width: 20%;">
                    <p>Course Joining:</p>
                </div>
                <div style = "width: 20%">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">UI Designing</p>
                    </div>
                </div>
                <div style = "width: 20%">
                    <p style="padding-left: 10px;">Timing:</p>
                </div>
                <div style = " width: 40%;">
                    <form style = "margin-top: 5%;">
                        <input type = "radio" value = "morning">
                        <label>Morning</label>
                        <input type = "radio" value = "afternoon">
                        <label>Afternoon</label>
                        <input type = "radio" value = "evening">
                        <label>Evening</label>
                    </form>
                </div>
                
            </div>
            <div style = " font-size: 14px; margin-top: -2%;">
                <div style = "width: 20%;">
                    <p>Attach:</p>
                </div>
            </div>
            <div style = " font-size: 14px; margin-top: -2%;">
                <div style = "width: 50%; ">
                    <form>
                        <input type = "checkbox">
                        <label>Xerox of Higher Qualification Certificate</label>
                    </form>
                </div>
                <div style = "width: 50%; ">
                    <form>
                        <input type = "checkbox">
                        <label>Xerox of Student's Adhaar</label>
                    </form>
                </div>
            </div>
            <div style = " font-size: 14px; ;">
                <div style = "width: 50%; ">
                    <form>
                        <input type = "checkbox">
                        <label>Address Proof</label>
                    </form>
                </div>
                <div style = "width: 50%; ">
                    <form>
                        <input type = "checkbox">
                        <label>Latest Photograph</label>
                    </form>
                </div>
            </div>
            <div style = " font-size: 14px; margin-top: -1%;">
                <div style = "width: 20%;">
                    <p>Date:</p>
                </div>
                <div style = "width: 30%">
                    <div style = " padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">13/09/2021</p>
                    </div>
                </div>
                <div style = "width: 30%">
                    <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                        <p style = "padding-bottom: 0%;">signature here</p>
                    </div>
                </div>
                <div style = "width: 20%;">
                    <p  style="padding-left: 10px;">Student Signature</p>
                </div>
                
            </div>
            
            
        </div>
        <div style = "background-color: rgb(226, 223, 223); font-size: 14px; margin-top: -5%;">
            <p style = "text-align: center; padding-top: 1%;">FOR OFFICE USE ONLY</p>
            <div style = "padding: 2%;">
                <div style = " font-size: 14px;  margin-top: -2%;">
                    <div style = "width: 20%;">
                        <p>Admission Number:</p>
                    </div>
                    <div style = "width: 80%;">
                        <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                            <p style = "padding-bottom: 0%;">2074</p>
                        </div>
                    </div>
                </div>
                <div style = " font-size: 14px;  margin-top: -2%;">
                    <div style = "width: 20%;">
                        <p>Remarks:</p>
                    </div>
                    <div style = "width: 80%;">
                        <div style = "border-bottom: 1px solid black; padding-bottom: 0%; height: 20px;">
                            <p style = "padding-bottom: 0%;">remarks here</p>
                        </div>
                    </div>
                </div>
                <div style = " font-size: 14px; margin-top: -1%;">
                    <div style = "width: 20%;">
                        <p>Admin Signature</p>
                    </div>
                    <div style = "width: 30%">
                        <div style = " padding-bottom: 0%; height: 20px;">
                            <p style = "padding-bottom: 0%;">sign here</p>
                        </div>
                    </div>
                    <div style = "width: 30%">
                        <div style = " padding-bottom: 0%; height: 20px;">
                            <p style = "padding-bottom: 0%;">sign here</p>
                        </div>
                    </div>
                    <div style = "width: 20%;">
                        <p  style="padding-left: 10px;">Director Signature</p>
                    </div>
                    
                </div>
            </div>
        </div>
        </div>
    </page>
    <div class="pagebreak"></div>
    
    <page>
        <h2 style = "text-align: center;">COMPUTER LABORATORY RULES AND REGULATIONS</h2>
        <div style = "padding: 2%; font-size: 14px;">
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
</body>
</html>