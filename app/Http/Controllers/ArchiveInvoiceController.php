<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchiveInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $invoices = Invoices::onlyTrashed()->get();
        return view('invoices.archiveInvoices',compact('invoices'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $archiveInvoice)
    {
        $invoice = Invoices::withTrashed()->where('id',$archiveInvoice)->restore();
        return to_route('invoices.index')->with('restored','تم أستعادة الفاتورة بنجاح من الأرشيف');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $archiveInvoice)
    {
        dd($archiveInvoice);
        // get invoice date
        $invoice_table = Invoices::withTrashed()->where('id',$archiveInvoice);
        $invoice_attachments = invoice_attachment::where('invoice_id',$archiveInvoice)->first();

        // remove attachments form local_storage
        if(!empty($invoice_attachments->invoice_number)):
            Storage::disk('public_uploads')->deleteDirectory($invoice_attachments->invoice_number);
        endif;

        // remove all invoice date from DB
        $invoice_table->forceDelete();
        return to_route('invoices.index')->with('deleted','تم حذف الفاتورة بنجاح');
    }
}
