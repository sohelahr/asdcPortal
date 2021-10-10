<?php

namespace Modules\SerialNumberConfigurations\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SerialNumberConfigurations\Entities\SerialNumberConfiguration;

class SerialNumberConfigurationsController extends Controller
{
    
    public static function generateNewSerialNumber($id,$slug){
        $serial_number = new SerialNumberConfiguration;
        $serial_number->initialRollNumber = '1001';
        $serial_number->currentRollNumber = '1001';
        $serial_number->slug = $slug;
        $serial_number->initialAdmissionNumber = '1001';
        $serial_number->currentAdmissionNumber = '1001';
        $serial_number->course_id = $id;
        $serial_number->save();
   }
   
    public static function getCurrentNumbers($id)
    {
        $serial_number = SerialNumberConfiguration::where('course_id',$id)->first();
        return $serial_number;
    }

    public static function incrementNumbers($id)
    {
        $serial_number = SerialNumberConfiguration::where('course_id',$id)->first();
        if(isset($serial_number))
        {
            $serial_number->currentRollNumber = $serial_number->currentRollNumber + 1;
            $serial_number->currentAdmissionNumber = $serial_number->currentAdmissionNumber + 1;
            $serial_number->save();
        }
        return;
    }
}
