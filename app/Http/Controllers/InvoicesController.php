<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Exports\PaidInvoicesExport;
use App\Exports\UnpaidInvoicesExport;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\StroeInvoice;
use App\Http\Requests\UpdateInvoice;
use App\Http\Requests\UpdateStatus;
use App\Http\traits\UploadFile;
use App\Models\invoice_attachment;
use App\Models\invoice_detail;
use App\Models\Invoices;
use App\Models\Product;
use App\Models\Section;
use App\Models\User;
use App\Notifications\AddInvoice;
use App\Notifications\NewInvoiceNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesController extends Controller
{
    use UploadFile;
    public function index()
    {
        $invoices = Invoices::with('section')->get();
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
    public function store(StroeInvoice $request)
    {
        // create new invoice
    DB::transaction(function () use( $request){
       $latestOne = Invoices::create([
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
        $newInvoice_id = $latestOne->id;

        DB::table('invoice_details')->insert([
            'invoice_number'=> $request->invoice_number,
            'invoice_id'    => $newInvoice_id,
            'status'        => 'unpaid',
            'value_status'  =>   2,
            'product'       =>  $request->product ,
            'section'       =>  $request->Section ,
            'note'          =>  $request->note ,
            'user'          =>  ( Auth::user()->name ),
            'created_at'    =>  ( now()),
        ]);

            // create invoice attachment = it's nullable()
        if ($request->hasFile('pic'))  {
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
             $request->validate(
                 ['pic' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',],
                 ['pic.mimes' => 'invoice saved but Attachment not  ', ]
             );

            $unique_name = $this->UploadFile($request->file('pic') ,Invoices::File_PATH.$request->invoice_number);
            DB::table('invoice_attachments')->insert([
                'file_name'     => $unique_name ,
                'invoice_number'=> $request->invoice_number ,
                'user'          => (Auth::user()->name),
                'invoice_id'    => $newInvoice_id,
                'created_at'    =>  ( now()),
            ]);

        }

        $invoice = Invoices::latest()->first(); // that attach related to
        /*//Notification::send(Auth::user() , new AddInvoice($invoice->id));*/

        $users = User::get(); // to all users
        Notification::send($users , new NewInvoiceNotification($invoice) ); // after Commit

    });

        return redirect()->route('invoices.index')->with('success','invoice added successfully');
    }


    public function allRead( )
    {
        foreach (\auth()->user()->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return back();
    }



    public function edit($invoice)
    {
        $show_invoice = Invoices::findOrFail($invoice);
        $sections = Section::get();
        return view('invoices.edit' , compact('show_invoice','sections'));
    }

    public function update(UpdateInvoice $request, $invoice)
    {

        DB::transaction(function () use ($request, $invoice){
            DB::table('Invoices')
                ->where('id',$invoice)
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
                "note"               => $request->note,
                'updated_at'    =>  ( now()),
            ]);
            // update invoice_details
            DB::table('invoice_details')
                ->where('invoice_id',$invoice )
                ->update([
                'product'       =>  $request->product ,
                'section'       =>  $request->Section ,
                'note'          =>  $request->note ,
                'user'          =>  ( Auth::user()->name ),
                'updated_at'    =>  ( now()),
            ]);
        });

        return to_route('invoices.index')->with('updated','Editing Done');
    }

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

    public function updateStatus(UpdateStatus $request , $invoice){

        $get_invoice= Invoices::findOrFail($invoice);

        DB::transaction(function () use ( $request , $get_invoice ,$invoice){
            $status = ($request->status == "1") ? 'paid': 'partially_paid  ' ;
            $get_invoice->update([
                    'status'        => $status,
                    'value_status'  => $request->status ,
                    'payment_date'  => (date('Y-m-d',strtotime($request->Payment_date))) ,
                ]);

            // create new invoice_details for new status
           DB::table('invoice_details')->insert([
                'invoice_id'    => $invoice,
                'status'        => $status,
                'value_status'  => $request->status,
                'payment_date'  => (date('Y-m-d',strtotime($request->Payment_date))) ,
                'invoice_number'=> $get_invoice->invoice_number,
                'product'       => $get_invoice->product ,
                'section'       => $get_invoice->section_id ,
                'note'          => $get_invoice->note ,
                'user'          => ( Auth::user()->name ),
                'created_at'    =>  now() ,
            ]);
        });
        return to_route('invoices.index')->with('statusUpdated','Status has been updated ');
    }


    public function  paidInvoice(){
        $invoices = Invoices::paid()->get();
        return view('invoices.paidInvoices',compact('invoices'));
    }
    public function unPaidInvoice (){
        $invoices = Invoices::unpaid()->get();
        return view('invoices.unPaidInvoices',compact('invoices'));
    }
    public function  partiallyPaidInvoice(){
        $invoices = Invoices::partiallyPaid()->get();
        return view('invoices.partiallyPaidInvoices',compact('invoices'));

    }

    public function  printInvoice($invoice){
        $invoices = Invoices::findOrFail($invoice);
        return view('invoices.printInvoice',compact('invoices'));
    }

    public function export(){
        return Excel::download(new InvoicesExport, date('m-d',strtotime(now())).'invoices.xlsx');
    }
    public function export_paid(){
        return Excel::download(new PaidInvoicesExport, date('y-m-d',strtotime(now())).'PaidInvoices.xlsx');
    }
    public function export_Unpaid(){
        return Excel::download(new UnpaidInvoicesExport, date('y-m-d',strtotime(now())).'UnPaidInvoices.xlsx');
    }


    // ajax code
    public function getProducts($id){
        $products = DB::table('products')->where('section_id','=',$id)->pluck('product_name','id');
        return json_encode($products);

    }

}
