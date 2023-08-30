<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentController extends Controller
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
        $allowedMimeTypes = [  'image/jpeg', 'image/png', 'image/jpg','application/pdf'];
        $request->validate([
            'file_name'=> 'required|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $file = $request->file('file_name');
        $file_name = $file->getClientOriginalName();
        $unique_name = date('ymd').rand(100,10000).$file_name;

        /*'invoice_id'
        'invoice_number'*/
        invoice_attachment::create([
            'file_name'     => $unique_name ,
            'invoice_number'=> $request->invoice_number ,
            'user'          => (Auth::user()->name),
            'invoice_id'    => $request->invoice_id ,
        ]);

        $file->move(public_path('attachments/'.$request->invoice_number),$unique_name);
        return back()->with('success_attach','Attachment Added');

        //dd($request->invoice_id ,$request->invoice_number);
    }

    /**
     * Display the specified resource.
     */
    public function show(invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoice_attachment $invoice_attachment)
    {
        // remove from Db
        $file_delete = invoice_attachment::findOrFail($invoice_attachment->id);
        $file_delete->delete();
            // remove from our storage
        Storage::disk('public_uploads')->delete($invoice_attachment->invoice_number.'/'.$invoice_attachment->file_name);
        return redirect()->with(['deleted'=>'Attachment Deleted']);
    }
}
