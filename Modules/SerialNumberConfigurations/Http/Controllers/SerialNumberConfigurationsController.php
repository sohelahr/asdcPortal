<?php

namespace Modules\SerialNumberConfigurations\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SerialNumberConfigurations\Entities\SerialNumberConfiguration;

class SerialNumberConfigurationsController extends Controller
{
   function generateNewSerialNumber(){

   }
   
    /*public static function generate($slug)
    {
        $serial_number = SerialNumberConfiguration::where('slug',$slug)->first();
        $unique_id = $serial_number->current_value;
        return $unique_id;
    }

    /*public static function increment($slug)
    {
        $serial_number = SerialNumberConfiguration::where('slug',$slug)->first();
        if(isset($serial_number))
        {
            $serial_number->current_value = $serial_number->current_value + 1;
            $serial_number->save();
        }
        return;
    } */
}
