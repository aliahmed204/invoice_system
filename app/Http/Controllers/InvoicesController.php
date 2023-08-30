<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachment;
use App\Models\invoice_detail;
use App\Models\Invoices;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoices::get();
        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::get();
        return view('invoices.create',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // create new invoice
        Invoices::create([
         "invoice_number"     => $request->invoice_number ,
         "invoice_date"       => ( date('Y-m-d',strtotime($request->invoice_date))) ,
         "due_date"           => ( date('Y-m-d',strtotime($request->due_date))) ,
         "product"            => $request->product ,
         "section_id"         => $request->Section ,
         "amount_collection"  => $request->Amount_collection ,
         "amount_commission"  => $request->Amount_Commission ,
         "discount"           => $request->Discount,
         "value_vat"          => $request->Value_VAT ,
         "rate_vat"           => $request->Rate_VAT,
         "total"              => $request->Total ,
         "status"             => 'unpaid',
         "value_status"       => 2,
         "note"               => $request->note
        ]);

            // create invoice details throw last id add to invoices table
        $newInvoice_id = Invoices::latest()->first()->id;
        invoice_detail::create([
            'invoice_number'=> $request->invoice_number,
            'invoice_id'    => $newInvoice_id,
            'status'        => 'unpaid',
            'value_status'  =>   2,
            'product'       =>  $request->product ,
            'section'       =>  $request->Section ,
            'note'          =>  $request->note ,
            'user'          =>  ( Auth::user()->name ),
        ]);

            // create invoice attachment = it's nullable()
        if ($request->hasFile('pic')){

            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
             $request->validate([
                'pic' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
             ],[
               'pic.mimes' => 'invoice saved but Attachment not  ',
             ]);

            $invoice_id = Invoices::latest()->first()->id; // that attach related to

            // get file from request and get its name
            $file = $request->file('pic');
            $file_name = $file->getClientOriginalName();

            $unique_name = date('ymd').rand(100,10000).$file_name;


            invoice_attachment::create([
                'file_name'     => $unique_name ,
                'invoice_number'=> $request->invoice_number ,
                'user'          => (Auth::user()->name),
                'invoice_id'    => $invoice_id,
            ]);

            $file->move(public_path('attachments/'.$request->invoice_number),$unique_name);
        }

        return redirect()->route('invoices.index')->with('success','invoice added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($invoice)
    {
        $show_invoice = Invoices::findOrFail($invoice);
        $sections = Section::get();
        return view('invoices.edit' , compact('show_invoice','sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $invoice)
    {

        // create new invoice
        Invoices::where('id','=',$invoice)
            ->update([
            "invoice_date"       => ( date('Y-m-d',strtotime($request->invoice_date))) ,
            "due_date"           => ( date('Y-m-d',strtotime($request->due_date))) ,
            "product"            => $request->product ,
            "section_id"         => $request->Section ,
            "amount_collection"  => $request->Amount_collection ,
            "amount_commission"  => $request->Amount_Commission ,
            "discount"           => $request->Discount,
            "value_vat"          => $request->Value_VAT ,
            "rate_vat"           => $request->Rate_VAT,
            "total"              => $request->Total ,
            "note"               => $request->note
        ]);

        // update invoice_details
        invoice_detail::where('invoice_id',$invoice )->update([
            'product'       =>  $request->product ,
            'section'       =>  $request->Section ,
            'note'          =>  $request->note ,
            'user'          =>  ( Auth::user()->name ),
        ]);

        return to_route('invoices.index')->with('updated','Editing Done');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($invoice)
    {
       $check = Invoices::findOrfail($invoice);
       $check->delete();
        return to_route('invoices.index')->with('move','Invoice Moved To Archive');
    }

    public function forceDelete($invoice){
        // get invoice date
        $invoice_table = Invoices::findOrfail($invoice);
        $invoice_attachments = invoice_attachment::where('invoice_id',$invoice)->first();

        // remove attachments form local_storage
            if(!empty($invoice_attachments->invoice_number)):
                Storage::disk('public_uploads')->deleteDirectory($invoice_attachments->invoice_number);
            endif;

        // remove all invoice date from DB
        $invoice_table->forceDelete();
        return to_route('invoices.index')->with('deleted','Deleted Successfully');

    }

    public function editStatus($invoice){
        $show_invoice= Invoices::findOrFail($invoice);
        return view('invoices.editStatus',compact('show_invoice'));
    }

    public function updateStatus(Request $request , $invoice){
        // validation
        $get_invoice= Invoices::findOrFail($invoice);

        $status = ($request->status == "1") ? 'paid': 'partially_paid  ' ;

        $get_invoice->update([
                'status'        => $status,
                'value_status'  => $request->status ,
                'payment_date'  => (date('Y-m-d',strtotime($request->Payment_date))) ,
            ]);
        // create new invoice_details for new status


        invoice_detail::create([
            'invoice_id'    => $invoice,
            'status'        => $status,
            'value_status'  => $request->status,
            'payment_date'  => (date('Y-m-d',strtotime($request->Payment_date))) ,
            'invoice_number'=> $get_invoice->invoice_number,
            'product'       => $get_invoice->product ,
            'section'       => $get_invoice->section_id ,
            'note'          => $get_invoice->note ,
            'user'          => ( Auth::user()->name ),

        ]);

        return to_route('invoices.index')->with('statusUpdated','Status has been updated ');

    }


    public function  paidInvoice(){
        $invoices = Invoices::where('value_status' , '1')->get();
        return view('invoices.paidInvoices',compact('invoices'));
    }
    public function unPaidInvoice (){
        $invoices = Invoices::where('value_status' , '2')->get();
        return view('invoices.unPaidInvoices',compact('invoices'));
    }
    public function  partiallyPaidInvoice(){
        $invoices = Invoices::where('value_status' , '3')->get();
        return view('invoices.partiallyPaidInvoices',compact('invoices'));

    }

    public function  printInvoice($invoice){
        $invoices = Invoices::findOrFail($invoice);
        return view('invoices.printInvoice',compact('invoices'));
    }




    public function getProducts($id){
        $products = DB::table('products')->where('section_id','=',$id)->pluck('product_name','id');
        return json_encode($products);

    }

}
