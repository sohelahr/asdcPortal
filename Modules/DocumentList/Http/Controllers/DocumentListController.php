<?php

namespace Modules\DocumentList\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DocumentList\Entities\DocumentList;

class DocumentListController extends Controller
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
        $documents = DocumentList::all();
        return view('documentlist::index',compact(['documents']));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('documentlist::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $document_list = new DocumentList();
        $document_list->name = $request->name;
        $document_list->save();
        return redirect()->route('document_list')->with('created','created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('documentlist::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $document_list = DocumentList::find($id);
        return json_encode($document_list);
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
        $document_list = DocumentList::find($id);
        $document_list->name = $request->name;
        $document_list->save();
        return redirect()->route('document_list')->with('updated','updated successfully');
    }
 
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        $document_list = DocumentList::find($id);
        if($document_list->admissions()->first()){
           return redirect()->route('document_list')->With('prohibited','123'); 
        }

        if($document_list->delete())
            return redirect()->route('document_list')->with('deleted','updated successfully');
        else
            return redirect()->route('document_list')->with('error','something went wrong');
    }
}
