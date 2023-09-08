<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Section;
use Illuminate\Http\Request;

class UsersReportController extends Controller
{
    public function index(){
        $sections = Section::get();
        return view('reports.users_reports',compact('sections'));
    }

    public function search(Request $request){

        $request->validate([
            "Section" => "numeric",
            "product" => 'string|max:55',
            'invoice_date_start' => 'nullable|date',
            'invoice_date_end' => 'nullable|date'
        ]);

        $section_id  = $request->Section;
        $product  = $request->product;
        $date_start  = $request->invoice_date_start;
        $date_end  = $request->invoice_date_end;

        if ($section_id && $product){ // search with section and product
            $details = Invoices::where('section_id',$section_id)
                ->where('product',$product)
                ->where('section_id',$section_id)
                ->get();
        }else{ // search with all request
            $details = Invoices::where('section_id',$section_id)
                ->where('product',$product)
                ->whereBetween('invoice_date',[$date_start,$date_end])
                ->get();
        }

        $sections = Section::get();
        return view('reports.users_reports',compact('sections'))->withDetails($details);

    }
}
