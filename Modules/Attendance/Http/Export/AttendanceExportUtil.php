<?php

namespace Modules\Attendance\Http\Export;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExportUtil implements FromCollection, WithHeadings
{
    use Exportable;
    private $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return collect($this->transactions);
    }

    public function headings(): array
    {
        return [
            'Date',
            'EmployeeCode',
            'EmployeeName',
            'Department',
            'Status',
            'PunchRecords',
        ];
    }
}
