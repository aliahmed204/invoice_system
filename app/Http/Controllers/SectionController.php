<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSection;
use App\Http\Requests\UpdateSection;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Session;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::get();
       return view('sections.sections',compact('sections'));
    }

    public function store(StoreSection $request){
        $request->validated();
        Section::create([
            'section_name'=>$request->section_name,
            'description'=>$request->description,
            'created_by'=>(Auth::user()->name)
        ]);
        return back()->with('success','new section Added');
    }

    public function update(UpdateSection $request , Section $section) // i send id using input
    {
        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);
        return redirect('/sections')->with('updated', 'Editing Completed');
    }

    public function destroy(Section $section) // i send id with form
    {
        $section->delete();
        return redirect('/sections')->with('delete','Section Deleted');
    }
}
