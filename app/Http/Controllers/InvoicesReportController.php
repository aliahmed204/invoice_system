<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;

class InvoicesReportController extends Controller
{
    public function index(){
        return view ('reports.reports');
    }
    public function invoiceSearch(){
        return view ('reports.invoice_search');
    }

    public function search(Request $request){
        $status = $request->type;
        $start = (!empty($request->start_at)) ? date('Y-m-d',strtotime($request->start_at)) : '' ;
        $end =   (!empty($request->end_at)) ? date('Y-m-d',strtotime($request->end_at)) : '';

        $request->validate([ 'type' => 'required|numeric' ]);

        if ($status == 4) { // get all invoices
            $invoices = Invoices::with('section')->get();
        }elseif (empty($start) || empty($end)){ // get all invoices depend on status in DB
            $invoices = Invoices::where('value_status' , $status)->with('section')->get();
        }else{ // search be Date
            $invoices = Invoices::whereBetween('invoice_date',[$start,$end])->where('value_status' , $status)->with('section')->get();
        }

        return  to_route('reports.index')->with(['invoices'=>$invoices]);
    }

    public function findOne(Request $request){

         $request->validate([ 'invoice_number' => 'required|numeric' ]);
         $number = $request->invoice_number;
         $invoice = Invoices::where('invoice_number' , $number)->with('section')->first();
        return to_route('reports.invoiceSearch')->with(['invoice'=>$invoice]);
    }
}
