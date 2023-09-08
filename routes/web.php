<?php

use App\Http\Controllers\ArchiveInvoiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
// should be first thing in routes
//Auth::routes();
Auth::routes(['register'=> false]);
// user can't make register == admin will insert users manually


Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

//Route::get('/invoices', [InvoicesController::class, 'index'])->name('invoices')->middleware('auth');
Route::resource('/invoices',InvoicesController::class)->middleware('auth');
Route::delete('invoices.forceDelete/{invoice}', [InvoicesController::class , 'forceDelete'])->name('invoices.forceDelete')->middleware('auth');
Route::get('invoices.editStatus/{invoice}', [InvoicesController::class , 'editStatus'])->name('invoices.editStatus')->middleware('auth');
Route::patch('invoices.updateStatus/{invoice}', [InvoicesController::class , 'updateStatus'])->name('invoices.updateStatus')->middleware('auth');
// notification mark all read
Route::get('notification.allRead', [InvoicesController::class , 'allRead'])->name('allRead')->middleware('auth');

Route::get('paidInvoices', [InvoicesController::class , 'paidInvoice'])->name('paidInvoices')->middleware('auth');
Route::get('unPaidInvoices', [InvoicesController::class , 'unPaidInvoice'])->name('unPaidInvoices')->middleware('auth');
Route::get('partiallyPaidInvoices', [InvoicesController::class , 'partiallyPaidInvoice'])->name('partiallyPaidInvoices')->middleware('auth');
Route::get('printInvoices/{invoice}', [InvoicesController::class , 'printInvoice'])->name('printInvoices')->middleware('auth');
Route::get('export_invoices', [InvoicesController::class, 'export'])->name('export_invoices');
Route::get('export_paid_invoices', [InvoicesController::class, 'export_paid'])->name('export_paid_invoices');
Route::get('export_Unpaid_invoices', [InvoicesController::class, 'export_Unpaid'])->name('export_Unpaid_invoices');


Route::get('archiveInvoices', [ArchiveInvoiceController::class , 'index'])->name('archiveInvoices.index')->middleware('auth');
Route::patch('archiveInvoices/{archiveInvoice}/update', [ArchiveInvoiceController::class , 'update'])->name('archiveInvoices.update')->middleware('auth');
Route::delete('archiveInvoices/{archiveInvoice}/destroy', [ArchiveInvoiceController::class , 'destroy'])->name('archiveInvoices.destroy')->middleware('auth');


Route::resource('/invoice_details',InvoiceDetailController::class)->middleware('auth');
Route::resource('/invoice_attachments',InvoiceAttachmentController::class)->middleware('auth');


Route::resource('/sections',SectionController::class)->middleware('auth');
Route::resource('/products',ProductController::class)->middleware('auth');

Route::get('section/{id}',[InvoicesController::class,'getProducts'])->middleware('auth');

Route::get ('view_file/{invoice_number}/{file_name}' , [InvoiceDetailController::class ,'openFile'])
    ->name('view_file');
Route::get ('download_file/{invoice_number}/{file_name}' , [InvoiceDetailController::class ,'getFile'])
    ->name('download_file');



Route::middleware('auth')->group(function () {
    // Our resource routes
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
});

Route::group([
    'middleware'=>'auth',
],function(){
    Route::get('/reports',[InvoicesReportController::class,'index'])->name('reports.index');
    Route::get('/invoiceSearch',[InvoicesReportController::class,'invoiceSearch'])->name('reports.invoiceSearch');

    Route::match(['post','get'],'/reports/search',[InvoicesReportController::class,'search'])->name('reports.search');

    Route::match(['post','get'],'/getReport',[InvoicesReportController::class,'findOne'])->name('report.findOne');

});
// reports search
Route::get('/users-reports',[UsersReportController::class,'index'])->name('usersReports.index');
Route::match(['post','get'],'/users/search',[UsersReportController::class,'search'])->name('usersReports.search');


Route::get('/{page}', [AdminController::class,'index']); // always at the end
