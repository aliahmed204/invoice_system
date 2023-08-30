<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachment;
use App\Models\invoice_detail;
use App\Models\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(invoice_detail $invoice_detail)
    {
        /*"invoice_number" => "122"
        "invoice_id" => 1
        "status" => "غير مدفوعة"
        "value_status" => 2
        "product" => "cc"
        "section" => "1"
        "note" => "سمينبنسينمسيب"
        "user" => "ali"
        "created_at" => "2023-08-27 17:39:37"
        "updated_at" => "2023-08-27 17:39:37"*/

        // معلومات الفاتورة
        //$invoice_info = Invoices::where('id',$invoice_detail->invoice_id)->first();
        $invoice_info = Invoices::find($invoice_detail->invoice_id);

        // حالات الفاتورة الدفع ولسه
            $invoice_status = invoice_detail::where('invoice_id',$invoice_detail->invoice_id)->get();

        // المرفقات مع الفاتورة
            $invoice_attachments = invoice_attachment::where('invoice_id',$invoice_detail->invoice_id)->get();

        return view('invoices.invoice_details',compact('invoice_info','invoice_status','invoice_attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoice_detail $invoice_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice_detail $invoice_detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoice_detail $invoice_detail)
    {
        //
    }

    public function openFile($invoice_number , $file_name){
        // Storage::disk('public_uploads')->get($invoice_number.'/'.$file_name);

        $file = public_path('attachments\\'.$invoice_number.'\\'.$file_name);
        return response()->file($file);

    }
    public function getFile($invoice_number , $file_name){
        // Storage::disk('public_uploads')->get($invoice_number.'/'.$file_name);

        $file = public_path('attachments\\'.$invoice_number.'\\'.$file_name);

        return response()->download($file,$file_name);

    }
}
