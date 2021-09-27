<?php

namespace Modules\Course\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $courses = Course::all();
        return view('course::index',compact(['courses']));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('course::create');
    } 

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $course = new Course();
        $course->name = $request->name;
        $course->duration = $request->duration;
        $course->slug = $request->slug;
        $course->save();
        return redirect()->route('course_list')->with('created','course created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('course::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {       
        $course = Course::find($id);
        return json_encode($course);
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
        $course = Course::find($id);
        $course->name = $request->name;
        $course->duration = $request->duration;
        $course->slug = $request->slug;
        $course->save();
        return redirect()->route('course_list')->with('updated','course Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        $course = Course::find($id);
        if($course->delete())
            return redirect()->route('course_list')->with('updated','course Updated successfully');
        else
            return redirect()->route('course_list')->with('error','Something went Wrong');
    }
}