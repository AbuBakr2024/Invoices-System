<?php

namespace App\Http\Controllers;

use App\Models\invoices_details;
use App\Models\invoices_attachments;

use Illuminate\Http\Request;
use App\Models\sections;
use App\Models\invoices;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoice=invoices::all();
        $section=sections::all();
        $details=invoices_details::all();
      return view('invoices.invoices_details')->with("invoice", $invoice)->with("section",  $section)->with("details",  $details);
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
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $section=sections::all();
        $invoice=invoices::where('id',$id)->first();
        $details=invoices_details::where('id_invoice',$id)->get();
        $attachment=invoices_attachments::where('invoice_id',$id)->get();

        return view('invoices.invoices_details')->with("invoice", $invoice)->with("details",  $details)->with("attachment",  $attachment)->with("section",  $section);
    }


    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    public function destroy($id)
    {
        $attachment = invoices_attachments::find($id);
        if (!$attachment) {
            return response()->with("done","deleted file done", 404);
        }
        // Define the path to the attachment
        $filePath = public_path('Attachments/' . $attachment->invoice_number . '/' . $attachment->file_name);
        // Delete the file if it exists
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        // Delete the record from the database
        $attachment->delete();
        return redirect()->route('index.invoices')->with("done","deleted file done");
    }

    public function download($id)
    {
        $attachment = invoices_attachments::find($id);

    if (!$attachment) {
        return response()->with("done","deleted file done", 404);
    }

    // Define the path to the attachment
    $filePath = public_path('Attachments/' . $attachment->invoice_number . '/' . $attachment->file_name);

    // Check if the file exists
    if (!file_exists($filePath)) {
        return response()->with("done","deleted file done", 404);
    }

    // Return the file as a download response
    return response()->download($filePath, $attachment->file_name);
}
}


