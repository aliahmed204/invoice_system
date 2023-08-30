<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSection;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Session;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::get();
       return view('sections.sections',compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSection $request){
        $request->validated();
        Section::create([
            'section_name'=>$request->section_name,
            'description'=>$request->description,
            'created_by'=>(Auth::user()->name)
        ]);
        return redirect('/sections')->with('success','section Add Done');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) // i send id using input
    {
        $id = $request->id;
           // dd($id);
        $request->validate([
            'section_name' => "required|min:6|max:255|unique:sections,section_name,".$id,
            'description' => 'required|min:6',
        ]);

        $sections = Section::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        return redirect('/sections')->with('updated', 'Editing Completed');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section) // i send id with form
    {
        $id = $section->id;
        $sections = Section::find($id)
             ->delete();
        return redirect('/sections')->with('delete','Section Deleted');
    }
}
