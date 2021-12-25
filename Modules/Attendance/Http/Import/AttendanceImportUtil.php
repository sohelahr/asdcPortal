<?php

namespace Modules\Attendance\Http\Import;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Attendance\Entities\AttendanceImport;

class AttendanceImportUtil implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        ini_set('max_execution_time', 1800); 
        //dd($row);//300 seconds = 5 minutes
        //return $row[]
        return new AttendanceImport(
            [
                'Date' => isset($row['date']) ? $this->transformDate($row['date']): "Not found",
                'EmployeeCode' => isset($row['employee_code']) ? $row['employee_code'] : "Not found",
                'EmployeeName' => isset($row['employee_name']) ? $row['employee_name'] : "Not found",
                'Department' => isset($row['department']) ? $row['department'] : "Not found",
                'Status' => isset($row['status']) ? str_replace(' ', '',$row['status']) : "Not found",
                'PunchRecords' => isset($row['punch_records']) ? $row['punch_records'] : "Not found",
            ]
        );

    }

    public function transformDate($value, $format = 'Y-m-d')
    {
    
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}
