<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\sections;
use Illuminate\Http\Request;

class customers_report extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $section=sections::all();
        return view('reports.customers_reports')->with('section',$section);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function search(Request $request)
    {

       if($request->Section&& $request->product && $request->start_at =='' && $request->end_at ==''){

         $invoices=invoices::select("*")->where('section_id',"=",$request->Section)->where('product',"=",$request->product)->get();
         $section=sections::all();

         return view('reports.customers_reports')->with('section',$section)->with('invoices',$invoices);

        }else{
            $section=sections::all();

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);

            $invoices=invoices::select("*")->whereBetween("invoice_date",[$start_at,$end_at])->where('section_id',"=",$request->Section)->where('product',"=",$request->product)->get();

            return view('reports.customers_reports')->with('section',$section)->with('invoices',$invoices);

    };

}
}
