<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    public function index()
    {
        return view('admin::import_index');
    }

    public function importUsers()
    {
        $temp_data = DB::table('temp_import')->get();
        return $temp_data;
    }
    public function importProfiles()
    {
        //
    }
    public function importUserRegistration()
    {
        return view('admin::show');
    }

}
