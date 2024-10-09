<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\sections;
use Illuminate\Http\Request;

class invoice_report extends Controller
{

    public function index()
    {
     return view('reports.invoices_reports');
    }


    public function search(Request $request){

        $rdio = $request->rdio;


     // في حالة البحث بنوع الفاتورة

        if ($rdio == 1) {


     // في حالة عدم تحديد تاريخ
            if ($request->type && $request->start_at =='' && $request->end_at =='') {

               $invoices = invoices::select('*')->where('status','=',$request->type)->get();
            //    هنا علشان الكلمه اللى هى مثلا مدفوعه تفضل مكتوبه فى المربع بعد البحث
               $type = $request->type;
               $section=sections::all();

               return view('reports.invoices_reports',compact('type'))->with('invoices',$invoices)->with('section',$section);
            }

            // في حالة تحديد تاريخ استحقاق
            else {

              $start_at = date($request->start_at);
              $end_at = date($request->end_at);
              $type = $request->type;
              $section=sections::all();

                            //    هنا علشان تبحث بين تاريخين
              $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('status','=',$request->type)->get();
              return view('reports.invoices_reports',compact('type','start_at','end_at'))->with('invoices',$invoices)->with('section',$section);

            }



        }

    //====================================================================

    // في البحث برقم الفاتورة
        else {

            $invoices = invoices::select('*')->where('invoice_number','=',$request->invoice_number)->get();
            $section=sections::all();

            return view('reports.invoices_reports')->with('invoices',$invoices)->with('section',$section);

        }



        }

}
