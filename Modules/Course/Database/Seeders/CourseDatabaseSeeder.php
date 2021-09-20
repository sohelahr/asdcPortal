<?php

namespace Modules\Course\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\Course;

class CourseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $courses = [
            [
                "name" => "Digital Marketing",
                "Duration" => "3 months",
                "slug" => "DM" 
            ],
            [
                "name" => "Graphic Designing (2D)",
                "Duration" => "3 months",
                "slug" => "GD2D"
            ],
            [
                "name" => "Graphic Designing (3D)",
                "Duration" => "3 months",
                "slug" => "GD3D"
            ],
            [
                "name" => "Website Development",
                "Duration" => "3 months",
                "slug" => "WD"
            ],
            [
                "name" => "Accounting Course",
                "Duration" => "3 months",
                "slug" => "AC"
            ],
            [
                "name" => "MS-Office",
                "Duration" => "3 months",
                "slug" => "MO"
            ],
            [
                "name" => "English Language (Proficiency)",
                "Duration" => "45 Days",
                "slug" => "EL"
            ],
            [
                "name" => "Telugu Language",
                "Duration" => "45 Days",
                "slug" => "TL"
            ],
            [
                "name" => "Soft Skills",
                "Duration" => "3 Months",
                "slug" => "SS"
            ],
            [
                "name" => "Retails Sales & Marketing",
                "Duration" => "3 Months",
                "slug" => "RSM"
            ],
            [
                "name" => "Pre-Primary Teachers Training",
                "Duration" => "9 Months",
                "slug" => "EL"
            ],
        ];

        Course::insert($courses);
        // $this->call("OthersTableSeeder");
    }
}
