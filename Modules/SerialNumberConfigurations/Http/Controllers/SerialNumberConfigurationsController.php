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

    /* public static function setInitialRegistrationNumber()
    {
        $serial_number = new SerialNumberConfiguration;
        $serial_number->initialRollNumber = '10000001';
        $serial_number->currentRollNumber = '10000001';
        $serial_number->slug = 'Registration Number';
        $serial_number->initialAdmissionNumber = '0';
        $serial_number->currentAdmissionNumber = '0';
        $serial_number->course_id = '0';
        $serial_number->save();
    } */

    public static function getCurrentRegistrationNumber()
    {
        $serial_number = SerialNumberConfiguration::where('slug','Registration Number')->first();
        return $serial_number->currentRollNumber;
    }

    public static function incrementRegistrationNumber()
    {
        $serial_number = SerialNumberConfiguration::where('slug','Registration Number')->first();
        if(isset($serial_number))
        {
            $serial_number->currentRollNumber = $serial_number->currentRollNumber + 1;
            $serial_number->save();
        }
        return;
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

    public static function decrementNumbers($id)
    {
        $serial_number = SerialNumberConfiguration::where('course_id',$id)->first();
        if(isset($serial_number))
        {
            $serial_number->currentRollNumber = $serial_number->currentRollNumber - 1;
            $serial_number->currentAdmissionNumber = $serial_number->currentAdmissionNumber - 1;
            $serial_number->save();
        }
        return;
    }
}
