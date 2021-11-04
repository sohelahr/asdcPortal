<?php

namespace Modules\StudentEmployment\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admission\Entities\Admission;
use Modules\StudentEmployment\Entities\StudentEmployment;
use Yajra\DataTables\DataTables;

class StudentEmploymentController extends Controller
{

    function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('studentemployment::index');
    }

    function AllStudentEmployementData(){
        $employments = StudentEmployment::all();

        return DataTables::of($employments)
            ->addColumn('student_name',function($employement){
                if(\App\Http\Helpers\CheckPermission::hasPermission('view.student_employment')){
                        return ['perm'=>true,'student_name' => $employement->Student->name];
                    }
                    else{
                       return ["perm"=>false,'student_name' => $employement->Student->name];
                    }
                return ;
            })
            ->addColumn('course_name',function($employement){
                return $employement->Course->name;
            })
            ->addColumn('company_name',function($employement){
                return $employement->company_name;
            })
            ->make();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $employement = new StudentEmployment();
        $employement->company_name = $request->company_name;
        $employement->admission_id = $request->admission_id;

        $employement->course_id = $request->course_id;
        $employement->user_id = $request->user_id;

        $employement->designation = $request->designation;
        $employement->industry = $request->industry;
        $employement->salary = $request->salary;
        $employement->location = $request->location;
        $employement->employment_type = $request->employment_type;
        if($employement->save())
        {
            $admission = Admission::find($request->admission_id);
            $admission->status = '3';
            $admission->save();

            $profile = User::find($request->user_id)->UserProfile;
            $profile->status = '1';
            $profile->save();
            
            return redirect()->route('admission_show',[$request->admission_id])->with('employement_created','created');
        }
        else{
            return redirect()->route('admission_show',[$request->admission_id])->with('error','created');

        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $employment = StudentEmployment::find($id);
        $admission = $employment->Admission;
        return view('studentemployment::view',compact('admission','employment'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('studentemployment::edit');
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
        $employement = StudentEmployment::find($id);
        $employement->company_name = $request->company_name;
        $employement->designation = $request->designation;
        $employement->industry = $request->industry;
        $employement->salary = $request->salary;
        $employement->location = $request->location;
        $employement->employment_type = $request->employment_type;
        if($employement->save())
        {
            return redirect()->route('employment_view',[$id])->with('employment_updated','created');
        }
        else{
            return redirect()->route('employment_view',[$id])->with('error','created');

        }
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