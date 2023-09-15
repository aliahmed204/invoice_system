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

Auth::routes(['register'=> false]);

Route::group([
    'controller'=>HomeController::class
],function (){
    Route::get('/', 'loginPage')->name('loginPage')->middleware('guest');
    Route::get('/home',  'index')->name('home')->middleware('auth');
});

//Route::get('/invoices', [InvoicesController::class, 'index'])->name('invoices')->middleware('auth');
Route::resource('/invoices',InvoicesController::class)->middleware('auth');
Route::group([
    'controller'=> InvoicesController::class,
    'middleware' => 'auth'
],function (){
    Route::get('paidInvoices', 'paidInvoice')->name('paidInvoices');
    Route::get('unPaidInvoices', 'unPaidInvoice')->name('unPaidInvoices');
    Route::get('partiallyPaidInvoices', 'partiallyPaidInvoice')->name('partiallyPaidInvoices');
    Route::get('printInvoices/{invoice}', 'printInvoice')->name('printInvoices');
    Route::get('export_invoices', 'export')->name('export_invoices');
    Route::get('export_paid_invoices', 'export_paid')->name('export_paid_invoices');
    Route::get('export_Unpaid_invoices', 'export_Unpaid')->name('export_Unpaid_invoices');

    // notification mark all read
    Route::get('notification.allRead', 'allRead')->name('allRead');
    // get product in specific section throw ajax
    Route::get('section/{id}','getProducts');

    Route::group([
        'prefix' => 'invoices',
        'as'=> 'invoices.'
    ],function (){
        Route::delete('/forceDelete/{invoice}', 'forceDelete')->name('forceDelete');
        Route::get('/editStatus/{invoice}', 'editStatus')->name('editStatus');
        Route::patch('/updateStatus/{invoice}', 'updateStatus')->name('updateStatus');
    });

});

Route::group([
    'prefix'=>'archiveInvoices',
    'as'=>'archiveInvoices.',
    'controller'=>ArchiveInvoiceController::class,
    'middleware'=> 'auth'
],function (){
    Route::get('/',  'index')->name('index');
    Route::patch('/{archiveInvoice}/update',  'update')->name('update');
    Route::delete('/{archiveInvoice}/destroy',  'destroy')->name('destroy');
});






Route::group([
    'middleware' => 'auth',
    'controller' => InvoiceAttachmentController::class,
],function () {

    Route::get ('view_file/{invoice_number}/{file_name}' , 'openFile')->name('view_file');
    Route::get ('download_file/{invoice_number}/{file_name}' , 'getFile')->name('download_file');

    Route::group([
        'prefix' => 'invoice_attachments',
        'as' =>'invoice_attachments.',
    ],function () {
    Route::delete('/{invoice_attachment}','destroy')->name('destroy');
    Route::post('/store','store')->name('store');
    });

});


Route::middleware('auth')->group(function () {
    Route::resource('/invoice_details',InvoiceDetailController::class);
    Route::resource('/sections',SectionController::class);
    Route::resource('/products',ProductController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
});

Route::group([
    'middleware'=>'auth',
    'controller'=>InvoicesReportController::class,
],function(){
    Route::get('/reports','index')->name('reports.index');
    Route::get('/invoiceSearch','invoiceSearch')->name('reports.invoiceSearch');
    Route::match(['post','get'],'/reports/search','search')->name('reports.search');

    Route::match(['post','get'],'/getReport','findOne')->name('report.findOne');

});

// reports search
Route::group([
    'middleware' => 'auth',
    'as' => 'usersReports.',
    'controller' => UsersReportController::class,
],function () {
    Route::get('/users-reports','index')->name('index');
    Route::match(['post','get'],'/users/search','search')->name('search');
});




Route::get('/{page}', [AdminController::class,'index']); // always at the end
