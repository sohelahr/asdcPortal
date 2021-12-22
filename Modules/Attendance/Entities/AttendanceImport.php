<?php

namespace Modules\Attendance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendanceImport extends Model
{
    use HasFactory;

    protected $fillable = ["Date","EmployeeCode" ,"EmployeeName","Company" ,
                            "Department","Category" ,"Designation",
                            "Shift","EarlyBy","Status","PunchRecords","Overtime"];
    

}
