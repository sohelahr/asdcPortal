<?php

namespace Modules\Occupation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Occupation\Entities\Occupation;
use Yajra\DataTables\DataTables;

class OccupationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('occupation::index');
    }

    function OccupationData(){
        $documents = Occupation::orderby('id','DESC')->get();
        
        return DataTables::of($documents)
                ->addIndexColumn()
                ->addColumn('perm',function($document){
                    $perm = [];
                    if(\App\Http\Helpers\CheckPermission::hasPermission('update.occupations')){
                        array_push($perm,true);
                    }
                    else{
                        array_push($perm,false);
                    }

                    if(\App\Http\Helpers\CheckPermission::hasPermission('delete.occupations')){
                        array_push($perm,true);
                    }
                    else{
                        array_push($perm,false);
                    }

                    return ['edit_perm' => $perm[0],'delete_perm' => $perm[1]];
                })
                ->make();
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('occupation::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $occupation = new Occupation();
        $occupation->name = $request->name;
        $occupation->save();
        return redirect()->route('occupations')->with('created','created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('occupation::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $occupation = Occupation::find($id);
        return json_encode($occupation);
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
        $occupation = Occupation::find($id);
        $occupation->name = $request->name;
        $occupation->save();
        return redirect()->route('occupations')->with('updated','created successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        $occupation = Occupation::find($id);
        if($occupation->UserProfile->count() > 0){
           return redirect()->route('occupations')->With('prohibited','123'); 
        }

        if($occupation->delete())
            return redirect()->route('occupations')->with('deleted','created successfully');
        else
            return redirect()->route('occupations')->with('error','Error something went wrong');
        
    }
}
