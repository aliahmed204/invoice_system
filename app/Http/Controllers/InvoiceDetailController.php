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
    public function show( $invoice_detail)
    {
        $invoice_info = Invoices::with('section')->findOrFail($invoice_detail);
        // payment status
        $invoice_status = invoice_detail::where('invoice_id',$invoice_detail)->get();
        // invoice attachment
        $invoice_attachments = invoice_attachment::where('invoice_id',$invoice_detail)->get();

        return view('invoices.invoice_details',compact('invoice_info','invoice_status','invoice_attachments'));
    }


}
