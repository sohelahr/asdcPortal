<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\DB;

class GetLocation
{
    public static function getOneCountry($id){
        $country = DB::table('countries')->where('id',$id)->get();
        return $country;
    }
    public static function getOneState($id){
        $state = DB::table('states')->where('id',$id)->get();
        return $state;
    }
    public static function getOneCity($id){
        $city = DB::table('cities')->where('id',$id)->get();
        return $city;
    }
    public static function getCountries($id){
        $countries = DB::table('countries')->all();
        return $countries;
    }
    public static function getStates($country_id){
        $states = DB::table('states')->where('country_id',$country_id)->get();
        return $states;
    }
    public static function getCities($state_id){
        $cities = DB::table('cities')->where('state_id',$state_id)->get();
        return $cities;
    }
}