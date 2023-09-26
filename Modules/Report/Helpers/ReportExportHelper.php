<?php

namespace Modules\Report\Helpers;


use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportExportHelper implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    use Exportable;
    private $headers;
    private $data;

    public function __construct($headers, $data)
    {
        $this->headers = [];
        $table_col_count = count($headers);
        for ($i = 0; $i < $table_col_count; $i++) {

            $col_name = $headers[$i];
            $col_display_name = ucfirst($col_name);
            $col_display_name = str_replace("_id", "", $col_display_name);
            $col_display_name = str_replace("_", " ", $col_display_name);

            //$col_name != "user_id" && $col_name != "student_id"
            if ($col_display_name == "User" || $col_display_name == "Student") {
                $col_display_name = "Email";
            }

            array_push($this->headers, $col_display_name);
        }
        $this->data = $data;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('1')->getFont()->setSize(12);
        //$sheet->getStyle('1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFA0A0A0');
        $sheet->getStyle('1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
        // return [
        //     // Style the first row as bold text.
        //     1    => [
        //         'font' => ['bold' => true, 'size' => 12],
        //         'background' => [ 'color'=> '#000000']
        //     ],
        // ];
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return $this->headers;
    }
}