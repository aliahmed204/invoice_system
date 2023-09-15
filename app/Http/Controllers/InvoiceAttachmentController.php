<?php

namespace App\Http\Controllers;

use App\Http\traits\UploadFile;
use App\Models\invoice_attachment;
use App\Models\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentController extends Controller
{
   use UploadFile;
    public function store(Request $request)
    {
        $request->validate(['file_name'=> 'required|mimes:jpeg,png,jpg,pdf|max:2048',]);
        $unique_name = $this->UploadFile( $request->file('file_name') , Invoices::File_PATH.$request->invoice_number
        );
        invoice_attachment::create([
            'file_name'     => $unique_name ,
            'invoice_number'=> $request->invoice_number ,
            'user'          => (Auth::user()->name),
            'invoice_id'    => $request->invoice_id ,
        ]);
        return back()->with('success_attach','Attachment Added');
    }

    public function openFile($invoice_number , $file_name){
        $file = public_path('attachments\\'.$invoice_number.'\\'.$file_name);
        return response()->file($file);
    }
    public function getFile($invoice_number , $file_name){
        $file = public_path('attachments\\'.$invoice_number.'\\'.$file_name);
        return response()->download($file,$file_name);
    }

    public function destroy($invoice_attachment)
    {
//dd($invoice_attachment);
             // remove from Db
            $file_delete = invoice_attachment::findOrFail($invoice_attachment);
            $file_delete->delete();
             // remove from our storage
        Storage::disk('public_uploads')->delete($file_delete->invoice_number.'/'.$file_delete->file_name);

        return back()->with(['deleted'=>'Attachment Deleted']);
    }
}
