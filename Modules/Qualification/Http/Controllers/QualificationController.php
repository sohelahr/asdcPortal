<?php

namespace Modules\Qualification\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Qualification\Entities\Qualification;
use Yajra\DataTables\DataTables;

class QualificationController extends Controller
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
        return view('qualification::index');
    }

    function QualificationData(){
        $documents = Qualification::orderby('id','DESC')->get();
        
        return DataTables::of($documents)
                ->addIndexColumn()
                ->addColumn('perm',function($document){
                    $perm = [];
                    if(\App\Http\Helpers\CheckPermission::hasPermission('update.qualifications')){
                        array_push($perm,true);
                    }
                    else{
                        array_push($perm,false);
                    }

                    if(\App\Http\Helpers\CheckPermission::hasPermission('delete.qualifications')){
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
        
        return view('qualification::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $qualification = new Qualification();
        $qualification->name =  $request->name;
        $qualification->save();
        return redirect()->route('qualifications')->with('created','Created Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('qualification::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $qualification = Qualification::find($id);
        return json_encode($qualification);
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
        $qualification = Qualification::find($id);
        $qualification->name =  $request->name;
        $qualification->save();
        return redirect()->route('qualifications')->with('updated','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        $qualification = Qualification::find($id);
        if($qualification->UserProfile->count() > 0){
           return redirect()->route('qualifications')->With('prohibited','123'); 
        }

        if($qualification->delete())
        return redirect()->route('qualifications')->with('created','Created Successfully');
        else
        return redirect()->route('qualifications')->with('error','Something went wrong');
    }
}
