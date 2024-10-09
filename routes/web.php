<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\customers_report;
use App\Http\Controllers\invoice_report;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;





Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/{page}',[AdminController::class,'index'])->name('genral');




//sections routes

//index show all sections
Route::prefix("sections")->group(function(){
Route::get('/index', [SectionsController::class,'index'])->name('index.section');
Route::post('/store', [SectionsController::class,'store'])->name('store.section');
Route::get('/edit/{id}', [SectionsController::class,'edit'])->name('edit.section');
Route::post('/update/{id}', [SectionsController::class,'update'])->name('update.section');
Route::delete('/delete/{id}', [SectionsController::class,'destroy'])->name('delete.section');


});

//products routes

//index show all products
Route::prefix("products")->group(function(){
    Route::get('/index', [ProductsController::class,'index'])->name('index.product');
     Route::post('/store', [ProductsController::class,'store'])->name('store.product');
     Route::get('/edit/{id}', [ProductsController::class,'edit'])->name('edit.product');
     Route::post('/update/{id}', [ProductsController::class,'update'])->name('update.product');
     Route::delete('/delete/{id}', [ProductsController::class,'destroy'])->name('delete.product');


    });





//invoices routes

//index show all invoices
Route::prefix("invoices")->group(function(){
Route::get('/index', [InvoicesController::class,'index'])->name('index.invoices');
Route::get('/create', [InvoicesController::class,'create'])->name('create.invoices');
Route::post('/store', [InvoicesController::class,'store'])->name('store.invoices');
Route::get('/getproducts/{id}',[InvoicesController::class,'getproducts'])->name('getproducts.invoices');
Route::get('/edit/{id}',[InvoicesController::class,'edit'])->name('edit.invoices');
Route::post('/update/{id}',[InvoicesController::class,'update'])->name('update.invoices');
Route::delete('/delete/{id}',[InvoicesController::class,'destroy'])->name('delete.invoices');
Route::get('/show/{id}',[InvoicesController::class,'show'])->name('show.invoices');
Route::post('/status/{id}',[InvoicesController::class,'status'])->name('status.invoices');
Route::get('/paid', [InvoicesController::class,'paid'])->name('paid.invoices');
Route::get('/unpaid', [InvoicesController::class,'unpaid'])->name('unpaid.invoices');
Route::get('/partial', [InvoicesController::class,'partial'])->name('partial.invoices');
Route::get('/archive', [InvoicesController::class,'archive'])->name('archive.invoices');
Route::post('/move/{id}',[InvoicesController::class,'move'])->name('move.invoices');
Route::delete('/destroyarchive/{id}',[InvoicesController::class,'destroyarchive'])->name('destroyarchive.invoices');
Route::get('/print/{id}',[InvoicesController::class,'print'])->name('print.invoices');
Route::get('/MarkAsRead_all',[InvoicesController::class,'MarkAsRead_all'])->name('MarkAsRead_all.invoices');

});


Route::prefix("invoicesdetails")->group(function(){

    Route::get('/index',[InvoicesDetailsController::class, 'index'])->name('index.invoicesdetails');
    Route::get('/show/{id}',[InvoicesDetailsController::class, 'show'])->name('show.invoicesdetails');
    Route::get('/{id}',[InvoicesDetailsController::class, 'edit'])->name('edit.invoicesdetails');
    Route::delete('/delete/{id}', [InvoicesDetailsController::class,'destroy'])->name('delete.invoicesattachments');
    Route::get('/download/{id}',[InvoicesDetailsController::class, 'download'])->name('download.invoicesattachments');
});

Route::prefix("invoicesattachments")->group(function(){

    Route::post('/store', [InvoicesAttachmentsController::class,'store'])->name('store.invoicesattachments');

});




Route::group(['middleware' => ['auth']], function () {

    Route::prefix("roles")->group(function(){

        Route::get('/index',[RoleController::class , 'index'])->name('index.role');
        Route::get('/create',[RoleController::class , 'create'])->name('create.role');
        Route::get('/edit/{id}',[RoleController::class,'edit'])->name('edit.role');
        Route::get('/show/{id}',[RoleController::class, 'show'])->name('show.role');
        Route::PATCH('/update/{id}',[RoleController::class,'update'])->name('update.role');
        Route::post('/store', [RoleController::class,'store'])->name('store.role');
        Route::delete('/delete/{id}', [RoleController::class,'destroy'])->name('delete.role');

    });



Route::prefix("users")->group(function(){

    Route::get('/index',[UserController::class , 'index'])->name('index.user');
    Route::get('/create',[UserController::class , 'create'])->name('create.user');
    Route::get('/edit/{id}',[UserController::class,'edit'])->name('edit.user');
    Route::post('/store', [UserController::class,'store'])->name('store.user');
    Route::PATCH('/update/{id}',[UserController::class,'update'])->name('update.user');
    Route::delete('/delete/{id}', [UserController::class,'destroy'])->name('delete.user');

});

});



Route::prefix("invoice_report")->group(function(){

        Route::get('/index', [invoice_report::class, 'index'])->name('index.report');
        Route::post('/search', [invoice_report::class, 'search'])->name('search.report');

});


Route::prefix("customers_report")->group(function(){

    Route::get('/index', [customers_report::class, 'index'])->name('index.cust_report');
    Route::post('/search', [customers_report::class, 'search'])->name('search.cust_report');

});


