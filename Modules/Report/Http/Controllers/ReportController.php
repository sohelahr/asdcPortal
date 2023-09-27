<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Report\Helpers\ReportExportHelper;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public static function reportingEntities()
    {
        $reporting_entities_arr = [];
        $reporting_entities_arr['user_profiles'] = 'Student';
        $reporting_entities_arr['registrations'] = 'Registration';
        $reporting_entities_arr['admissions'] = 'Admission';
        // $reporting_entities_arr['feedback_lines'] = 'Feedbacks';
        // $reporting_entities_arr['assessment_lines'] = 'Assessments';
        $reporting_entities_arr['student_employments'] = 'Employment';
        return $reporting_entities_arr;
    }

    public static function allowedConditionalOperators()
    {
        $condition_arr = array(
            array(
                'key' => '=',
                'value' => 'Equals To'
            ),
            array(
                'key' => '>',
                'value' => 'Greater Than'
            ),
            array(
                'key' => '<',
                'value' => 'Less Than'
            ),
            array(
                'key' => '>=',
                'value' => 'Greater Than Equals To'
            ),
            array(
                'key' => '<=',
                'value' => 'Less Than Equals To'
            ),
            array(
                'key' => '!=',
                'value' => 'Not Equals To'
            ),
            array(
                'key' => 'like',
                'value' => 'Has letters'
            ),
        );
        return $condition_arr;
    }

    public static function getForeignAndUnneccessaryKeys()
    {
        return [
            "unneccessary" => [
                "is_imported",
                "created_by",
                "updated_at"
            ],

            "foreign_keys" => [
                "user_id" => ["users", "email"],
                "student_id" => ["users", "email"],
                "occupation_id" => ["occupations", "name"],
                "qualification_id" => ["qualifications", "name"],
                // "city" => ["cities","city_name"],
                // "state" => ["states","name"],
                "course_id" => ["courses", "name"],
                "course_slot_id" => ["course_slots", "name"],
                "courseslot_id" => ["course_slots", "name"],
                "coursebatch_id" => ["course_batches", "batch_number"],
                "registration_id" => ["registrations", "registration_no"],
                "admission_id" => ["admissions", "admission_form_number"],
                "feedback_header_id" => ["feedback_headers", "instructor"],
            ]
        ];
    }

    public function index()
    {
        $looking_for = $this->reportingEntities();
        $conditional_operators = $this->allowedConditionalOperators();
        //dd($conditional_operators);
        return view('report::report', compact('looking_for', 'conditional_operators'));
    }

    public function fetchColumns($table_name)
    {
        $decoded_table_name = base64_decode($table_name);
        $columns = $this->getTableColumnName($decoded_table_name);
        return json_encode($columns);
    }

    public function fetchData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $table_name = $request->entity; // this holds table name
        $selectList = $request->select_arr; // this hold all the selected column
        $typeArr = $request->type_arr; // this hold all conditional operator selected
        $whereColumnArr = $request->where_column_arr; // this hold all the where condition column
        $whereOperatorArr = $request->where_condition_arr; // this hold all the where conditional operator
        $whereValueArr = $request->where_value_arr; // this hold all the where condition value


        $table = DB::table($table_name);
        $totalData = $table->count();
        $records = $table->select($selectList);

        if ($whereOperatorArr[0] != null || $whereValueArr[0] != null) {
            $val = $whereOperatorArr[0] == 'like' ? "%" . $whereValueArr[0] . "%" : $whereValueArr[0];
            $records = $records->where($whereColumnArr[0], $whereOperatorArr[0], $val);
        }


        if (count($whereColumnArr) > 1) {
            foreach ($whereColumnArr as $key => $whereColumn) {
                if ($key !== 0) {

                    $val = $whereOperatorArr[$key] == 'like' ? "%" . $whereValueArr[$key] . "%" : $whereValueArr[$key];

                    if ($typeArr[$key - 1] === "AND") {
                        $records = $records->where($whereColumn, $whereOperatorArr[$key], $val);
                    } else {
                        $records = $records->orWhere($whereColumn, $whereOperatorArr[$key], $val);
                    }

                }
            }
        }

        $totalFiltered = $records->count();
        $records = $records->skip($start)->limit($limit)->get();

        $keys = $this->getForeignAndUnneccessaryKeys();

        try {
            for ($i = 0; $i < $records->count(); $i++) {

                $row = json_decode(json_encode($records[$i]), true);
                $row_keys = array_keys($row);
                $table_col_count = count($row_keys);
                for ($j = 0; $j < $table_col_count; $j++) {

                    $col_name = $row_keys[$j];
                    $val = $row[$col_name];

                    if (array_key_exists($col_name, $keys['foreign_keys']) && $val !== null) {
                        $row[$col_name] = DB::table($keys['foreign_keys'][$col_name][0])->where("id", $val)->pluck($keys['foreign_keys'][$col_name][1])[0];
                    }
                }
                $records[$i] = $row;
            }
        } catch (\Throwable $th) {
            return $th;
        }

        // dd($records);

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $records
        );
        return json_encode($json_data);
    }

    public function getTableColumnName($table_name)
    {
        // try{
        $table_description = DB::select('DESC ' . $table_name);
        $table_columns = [];
        $table_col_count = count($table_description);
        $unwanted = $this->getForeignAndUnneccessaryKeys();

        if ($table_col_count > 0) {
            for ($i = 1; $i < $table_col_count; $i++) {

                $col_name = $table_description[$i]->Field;
                if (!in_array($col_name, $unwanted["unneccessary"])) {

                    $col_display_name = ucfirst($col_name);
                    $col_display_name = str_replace("_id", "", $col_display_name);
                    $col_display_name = str_replace("_", " ", $col_display_name);

                    //$col_name != "user_id" && $col_name != "student_id"
                    if ($col_display_name == "User" || $col_display_name == "Student") {
                        $col_display_name = "Email";
                    }

                    array_push($table_columns, ["actualVal" => $col_name, "displayName" => $col_display_name]);
                }
            }
        }

        return $table_columns;
        // }
        // catch (\Throwable $th) {
        //     return [];
        // }
    }

    public function exportReport(Request $request)
    {
        $table_name = $request->entity;
        $selectList = $request->select_arr;
        $typeArr = $request->type_arr;
        $whereColumnArr = $request->where_column_arr;
        $whereOperatorArr = $request->where_condition_arr;
        $whereValueArr = $request->where_value_arr;
        $records = DB::table($table_name);
        $records = $records->select($selectList);


        if ($whereOperatorArr[0] != null || $whereValueArr[0] != null) {
            $val = $whereOperatorArr[0] == 'like' ? "%" . $whereValueArr[0] . "%" : $whereValueArr[0];
            $records = $records->where($whereColumnArr[0], $whereOperatorArr[0], $val);
        }


        if (count($whereColumnArr) > 1) {
            foreach ($whereColumnArr as $key => $whereColumn) {
                if ($key !== 0) {

                    $val = $whereOperatorArr[$key] == 'like' ? "%" . $whereValueArr[$key] . "%" : $whereValueArr[$key];

                    if ($typeArr[$key - 1] === "AND") {
                        $records = $records->where($whereColumn, $whereOperatorArr[$key], $val);
                    } else {
                        $records = $records->orWhere($whereColumn, $whereOperatorArr[$key], $val);
                    }

                }
            }
        }

        $records = $records->get();

        $keys = $this->getForeignAndUnneccessaryKeys();

        for ($i = 0; $i < $records->count(); $i++) {

            $row = json_decode(json_encode($records[$i]), true);
            $row_keys = array_keys($row);
            $table_col_count = count($row_keys);
            for ($j = 0; $j < $table_col_count; $j++) {

                $col_name = $row_keys[$j];
                $val = $row[$col_name];

                if (array_key_exists($col_name, $keys['foreign_keys']) && $val !== null) {
                    $row[$col_name] = DB::table($keys['foreign_keys'][$col_name][0])->where("id", $val)->pluck($keys['foreign_keys'][$col_name][1])[0];
                }
            }
            $records[$i] = $row;
        }



        $records = $records->toArray();
        $file_name = $request->entity . '-' . Str::random(5) . '' . time() . '.xlsx';
        return Excel::download(new ReportExportHelper($selectList, $records), $file_name);
    }
}