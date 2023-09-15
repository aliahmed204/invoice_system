<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachment;
use App\Models\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchiveInvoiceController extends Controller
{
    public function index(){
        $invoices = Invoices::onlyTrashed()->get();
        return view('invoices.archiveInvoices',compact('invoices'));
    }

    public function update(string $archiveInvoice)
    {
        $invoice = Invoices::onlyTrashed()->where('id',$archiveInvoice)->restore();
        return to_route('invoices.index')->with('retrieved','the invoice has been successfully retrieved from the archive');

    }

    public function destroy( $archiveInvoice)
    {

        // get invoice date
        $invoice_table = Invoices::onlyTrashed()->where('id',$archiveInvoice)->first();
        $invoice_attachments = invoice_attachment::where('invoice_id',$archiveInvoice)->first();
        // remove attachments form local_storage
        if(!empty($invoice_attachments->invoice_number)):
            Storage::disk('public_uploads')->deleteDirectory($invoice_attachments->invoice_number);
        endif;
        // remove all invoice date from DB
        $invoice_table->forceDelete();
        return to_route('invoices.index')->with('deleted','invoice Deleted');
    }
}
