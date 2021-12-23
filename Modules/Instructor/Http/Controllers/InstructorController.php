<?php

namespace Modules\Instructor\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;
use Modules\Instructor\Entities\Instructor;
use Yajra\DataTables\DataTables;

class InstructorController extends Controller
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
        return view('instructor::index');
    }

    function InstructorData(Request $request){
        //$userprofiles = UserProfile::where('is_profile_completed',"1")->get();
        $limit = $request->length;
        $start = $request->start;
        $search = $request->search['value'];

        $instructors = Instructor::query();
               
        //$totalApplicationCount = $instructors->count();
        $totalRegistrationRecord = $instructors->count();
        
        if(isset($search))
        {
            $instructors = $instructors->where('name','LIKE','%'.$search.'%')
                                ->orWhere('course_id',function($query) use($search) {
                                    $query->select('id')->from('courses')->where('name','LIKE','%'.$search.'%');
                                });                              
        }
        $filteredRegistrationCount = $instructors->count();
        $instructors = $instructors->skip($start)->limit($limit)->get();
        //dd($userprofiles);

        if(isset($search))
        {
            $totalFiltered = $filteredRegistrationCount;
        }
        else
        {
            $totalFiltered = $totalRegistrationRecord;
        }
        return DataTables::of($instructors)
                ->addIndexColumn()
                ->addColumn('name',function($instructor){
                        return ['perm'=>true,'name'=> $instructor->firstname." ".$instructor->lastname];
                    /* if(\App\Http\Helpers\CheckPermission::hasPermission('view.profiles')){
                        return ['perm'=>true,'name'=> $profile->firstname." ".$profile->lastname];
                    }
                    else{
                       return ["perm"=>false,'name' => $profile->firstname." ".$profile->lastname];
                    } */
                })
                ->addColumn('course',function($instructor){
                    return $instructor->Course->name;
                })
                ->addColumn('edit',function($registration){
                    return \App\Http\Helpers\CheckPermission::hasPermission('update.profiles');
                })
                ->setTotalRecords($totalRegistrationRecord)
                ->setOffset($start)
                ->setFilteredRecords($totalFiltered)
                ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        
        $courses = Course::all();
        return view('instructor::create',compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $instructor =  new Instructor();
        $instructor->firstname = $request->firstname;
        $instructor->lastname = $request->lastname;
        $instructor->email = $request->email;
        $instructor->designation = $request->designation;
        $instructor->phone = $request->mobile; 
        $instructor->course_id = $request->course;
        $instructor->address = $request->address;

        //saving files
        if($request->file('photo')){
            $filename = 'instructor-'.time().".".$request->file('photo')->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs('/instructor_photos/',$filename);
            $instructor->photo = $filename;
        }/* 
        if($request->is_profile_completed) */
        $instructor->save();
        return redirect('/instructor')->with('created','xyz');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $instructor = Instructor::find($id);
        return view('instructor::view',compact('instructor'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $courses = Course::all();
        $instructor = Instructor::find($id);
        return view('instructor::edit',compact('courses','instructor'));
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
        $instructor = Instructor::find($id);
        $instructor->firstname = $request->firstname;
        $instructor->lastname = $request->lastname;
        $instructor->email = $request->email;
        $instructor->designation = $request->designation;
        $instructor->phone = $request->mobile; 
        $instructor->course_id = $request->course;
        $instructor->address = $request->address;

        //saving files
        if($request->file('photo')){
            $filename = 'instructor-'.time().".".$request->file('photo')->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs('/instructor_photos/',$filename);
            $instructor->photo = $filename;
        }/* 
        if($request->is_profile_completed) */
        $instructor->save();
        return redirect('/instructor')->with('updated','xyz');
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
