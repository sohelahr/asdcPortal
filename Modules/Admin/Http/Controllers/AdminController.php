<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Registration\Entities\Registration;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     * 
     * 
     */
    function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $yesterday = Carbon::now()->subDays(1);//get yesterday
        $one_week_ago = Carbon::now()->subWeeks(1);//get one week ago
        $data['new_users'] = User::where('user_type','3')
            ->whereBetween('created_at',[$one_week_ago,$yesterday])
            ->count();//get new users in aweek
        $data['total_users'] = User::where('user_type','3')->where('is_verified','1')->count();
        $data['new_user_percent'] = floor(($data['new_users']/$data['total_users']) * 100);

        $data['total_registration'] = Registration::count();
        $data['new_registration'] = Registration::whereBetween('created_at',[$one_week_ago,$yesterday])
            ->count();
        $data['new_reg_percent'] = floor(($data['new_registration']/$data['total_registration']) * 100);
        /* $data['graph_user'] = User::select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                            ->groupby('year','month')
                            ->get(); */
        return view('admin::dashboard',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
