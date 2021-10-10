<?php

namespace Modules\SerialNumberConfigurations\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SerialNumberConfigurations\Entities\SerialNumberConfiguration;

class SerialNumberConfigurationsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $serial_numbers= [
             [
                "slug" => "DM",
                "initial_value" => "1001",
                "current_value" => "1001",
                "course_id" => "1",
                "initialAdmissionNumber" => "1001",
                "currentAdmissionNumber" => "1001",
            ],
            [
                "slug" => "GD2D",
                "initial_value" => "1001",
                "current_value" => "1001",
                "course_id" => "2",
                "initialAdmissionNumber" => "1001",
                "currentAdmissionNumber" => "1001",
            ],
            [
                "slug" => "GD3D",
                "initial_value" => "1001",
                "current_value" => "1001",
                "course_id" => "3",
                "initialAdmissionNumber" => "1001",
                "currentAdmissionNumber" => "1001",
            ],
            [
                "slug" => "",
                "initial_value" => "1001",
                "current_value" => "1001",
                "course_id" => "4",
                "initialAdmissionNumber" => "1001",
                "currentAdmissionNumber" => "1001",
            ],
            [
                "slug" => "Roll Number",
                "initial_value" => "1001",
                "current_value" => "1001",
                "course_id" => "5",
                "initialAdmissionNumber" => "1001",
                "currentAdmissionNumber" => "1001",
            ],
            [
                "slug" => "Roll Number",
                "initial_value" => "1001",
                "current_value" => "1001",
                "course_id" => "6",
                "initialAdmissionNumber" => "1001",
                "currentAdmissionNumber" => "1001",
            ],
            [
                "slug" => "Roll Number",
                "initial_value" => "1001",
                "current_value" => "1001",
                "course_id" => "7",
                "initialAdmissionNumber" => "1001",
                "currentAdmissionNumber" => "1001",
            ],
            [
                "slug" => "Roll Number",
                "initial_value" => "1001",
                "current_value" => "1001",
                "course_id" => "8",
                "initialAdmissionNumber" => "1001",
                "currentAdmissionNumber" => "1001",
            ],
            [
                "slug" => "Roll Number",
                "initial_value" => "1001",
                "current_value" => "1001",
                "course_id" => "9",
                "initialAdmissionNumber" => "1001",
                "currentAdmissionNumber" => "1001",
            ],
            [
                "slug" => "Roll Number",
                "initial_value" => "1001",
                "current_value" => "1001",
                "course_id" => "10",
                "initialAdmissionNumber" => "1001",
                "currentAdmissionNumber" => "1001",
            ],
            [
                "slug" => "Roll Number",
                "initial_value" => "1001",
                "current_value" => "1001",
                "course_id" => "11",
                "initialAdmissionNumber" => "1001",
                "currentAdmissionNumber" => "1001",
            ],
            [
                "slug" => "Roll Number",
                "initial_value" => "1001",
                "current_value" => "1001",
                "course_id" => "12",
                "initialAdmissionNumber" => "1001",
                "currentAdmissionNumber" => "1001",
            ],
        ];
        SerialNumberConfiguration::insert($serial_numbers);
    }
}
