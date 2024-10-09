<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use App\Models\sections;
use App\Models\User;
use App\Notifications\addinvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoice=invoices::all();
        $section=sections::all();
        return view('invoices.index')->with("invoice", $invoice)->with("section",  $section);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $section=sections::all();
        return view('invoices.create')->with('section',$section);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $invoice= new invoices();
        $invoice->invoice_number=$request->invoice_number;
        $invoice->invoice_date=$request->invoice_Date;
        $invoice->due_date= $request->Due_date;
        $invoice->section_id= $request->Section;
        $invoice->product= $request->product;
        $invoice->amount_collection= $request->Amount_collection;
        $invoice->amount_commission= $request->Amount_Commission;
        $invoice->discount= $request->Discount;
        $invoice->value_vat= $request->Value_VAT;
        $invoice->rate_vat= $request->Rate_VAT;
        $invoice->total= $request->Total;
        $invoice->status= 'غير مدفوعه';
        $invoice->value_status= "2";
        $invoice->note= $request->note;
        $invoice->save();

// invoice_details

        $invoice_id=invoices::latest()->first()->id;

        $invoice_details= new invoices_details();
        $invoice_details->id_invoice=$invoice_id;
        $invoice_details->invoice_number=$request->invoice_number;
        $invoice_details->product= $request->product;
        $invoice_details->section= $request->Section;
        $invoice_details->status= "غير مدفوعه";
        $invoice_details->value_status= "2";
        $invoice_details->note= $request->note;
        $invoice_details->user= Auth::user()->name;
        $invoice_details->save();
// invoice_attachments

        if ($request->hasFile('pic')) {

        $invoice_id = Invoices::latest()->first()->id;

        $image = $request->file('pic');
        $file_name = $image->getClientOriginalName();
        $invoice_number = $request->invoice_number;

        $attachments = new invoices_attachments();
        $attachments->file_name = $file_name;
        $attachments->invoice_number = $invoice_number;
        $attachments->Created_by = Auth::user()->name;
        $attachments->invoice_id = $invoice_id;
        $attachments->save();

        // move pic
        $imageName = $request->pic->getClientOriginalName();
        $request->pic->move(public_path('Attachments/'), $imageName);

        }

    //  notification to email
        // $user = User::get();
        // Notification::send($user, new \App\Notifications\addinvoice($invoice_id));

//  notification to database

        $user = User::get();
        $invoices=invoices::latest()->first();
        Notification::send($user, new \App\Notifications\add($invoices));

        return redirect()->route('index.invoices')->with("done","تم اضافه الفاتوره بنجاح");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice=invoices::find($id);
        $section=sections::all();
        return view('invoices.showstatus')->with("invoice", $invoice)->with("section", $section);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice=invoices::find($id);
        $section=sections::all();
        return view('invoices.edit')->with("section", $section)->with("invoice", $invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $invoice=invoices::find($id);
        $invoice->invoice_number=$request->invoice_number;
        $invoice->invoice_date=$request->invoice_Date;
        $invoice->due_date= $request->Due_date;
        $invoice->section_id= $request->Section;
        $invoice->product= $request->product;
        $invoice->amount_collection= $request->Amount_collection;
        $invoice->amount_commission= $request->Amount_Commission;
        $invoice->discount= $request->Discount;
        $invoice->value_vat= $request->Value_VAT;
        $invoice->rate_vat= $request->Rate_VAT;
        $invoice->total= $request->Total;
        $invoice->status= 'غير مدفوعه';
        $invoice->value_status= "2";
        $invoice->note= $request->note;
        $invoice->save();
        return redirect()->route('index.invoices')->with("done","updated file done");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
       $invoice=invoices::find($id);

       $id_page=$request->id_page;

      if(!$id_page==2){

        $invoice->forceDelete();
        return redirect()->back()->with("done","deleted file done");

   }else{

    $invoice->Delete();

    return redirect()->back()->with("done","archive file done");

   }

    }


    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("product_name", "id");
        return json_encode($products);
    }

      // change status
    public function status(Request $request, $id)
    {
        $invoice=invoices::find($id);

      if($invoice->status == "مدفوعه"){
        $invoice->update([
            "status"=>$request->Status,
           "value_status"=>1,
           "payment_date"=>$request->payment_date
        ]);
        $invoice_details= new invoices_details();
        $invoice_details->id_invoice=$id;
        $invoice_details->invoice_number=$request->invoice_number;
        $invoice_details->product= $request->product;
        $invoice_details->section= $request->Section;
        $invoice_details->status= $request->Status;
        $invoice_details->value_status= "1";
        $invoice_details->note= $request->note;
        $invoice_details->user= Auth::user()->name;
        $invoice_details->payment_date= $request->payment_date;
        $invoice_details->save();
      }else{

        $invoice->update([
            "status"=>$request->Status,
           "value_status"=>3,
           "payment_date"=>$request->payment_date
        ]);
        $invoice_details= new invoices_details();
        $invoice_details->id_invoice=$id;
        $invoice_details->invoice_number=$request->invoice_number;
        $invoice_details->product= $request->product;
        $invoice_details->section= $request->Section;
        $invoice_details->status= $request->Status;
        $invoice_details->value_status= "3";
        $invoice_details->note= $request->note;
        $invoice_details->user= Auth::user()->name;
        $invoice_details->payment_date= $request->payment_date;
        $invoice_details->save();

      }


        return redirect()->route('index.invoices')->with("done","updated status");
    }

// select paid invoices

    public function paid(){


        $invoice=invoices::where("value_status",1)->get();
        $section=sections::all();
        return view('invoices.paid')->with('invoice',$invoice)->with('section',$section);


    }

         // select unpaid invoices

    public function unpaid(){

        $invoice=invoices::where("value_status",2)->get();
        $section=sections::all();
        return view('invoices.unpaid')->with('invoice',$invoice)->with('section',$section);

        }

        // select partial invoices
    public function partial(){

       $invoice=invoices::where("value_status",3)->get();

       $section=sections::all();

       return view('invoices.partial')->with('invoice',$invoice)->with('section',$section);

        }

          // select invoices archived in archive
    public function archive(){

       $invoice=invoices::onlyTrashed()->get();

       $section=sections::all();

       return view('invoices.archive')->with('invoice',$invoice)->with('section',$section);

        }
          // move to archive
    public function move($id){

      $invoice=invoices::withTrashed()->where("id",$id)->restore();

      return redirect()->route('index.invoices')->with('invoice',$invoice)->with("done","تم اعاده الفاتوره بنجاح");

        }

          // delete from archive
    public function destroyarchive($id){

       $invoice=invoices::withTrashed()->where("id",$id);

       $invoice->forceDelete();

       return redirect()->back()->with("done","تم حذف الارشيف بنجاح");

        }


    public function print($id){

       $invoice=invoices::find($id);

       $section=sections::all();

       return view('invoices.print_invoice')->with('invoice',$invoice)->with('section',$section);

        }


// علشان لما تدوس على كلمه قراءه الكل يحذف كل الرسايل علشان هيخليهم اتقروا علشان انتا بتعرض اللى ما اتقروش بس
    public function MarkAsRead_all(){

      $userUnreadNotification= auth()->user()->unreadNotifications;

      if($userUnreadNotification) {

      $userUnreadNotification->markAsRead();

       return back();

        }

 }
}
