<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product= products::all();
        $section=sections::all();
       return view('products.index')->with('product',$product)->with('section',$section);
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
        $request->validate([               // لا يتكرر الاسم داخل الداتا بيز
            'product_name'=>'required|string|unique:products',
            'description'=>'required|string',
          ],[

    'product_name.required'=>"يرجى ادخال اسم المنتج",
    'product_name.string'=>"يرجى ادخال الاسم بالحروف ",
    'product_name.unique'=>"القسم مسجل بالفعل",
    'description.required'=>"يرجى ادخال الملاحظات",
    'description.string'=>"يرجى ادخال الملاحظات بالحروف ",
          ]);

    $product= new products();
    $product->product_name=$request->product_name;
    $product->description=$request->description;
    $product->section_id=$request->section_id;
    $product->save();
    return redirect()->back()->with("done","تم اضافه القسم بنجاح");

    }

    /**
     * Display the specified resource.
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $section=sections::all();
        $product=products::find($id);
        return view('products.edit')->with("product",$product)->with("section",$section);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([               // لا يتكرر الاسم داخل الداتا بيز
            'product_name'=>'required|string|unique:products',
            'description'=>'required|string',
          ],[

    'product_name.required'=>"يرجى ادخال اسم المنتج",
    'product_name.string'=>"يرجى ادخال الاسم بالحروف ",
    'product_name.unique'=>"القسم مسجل بالفعل",
    'description.required'=>"يرجى ادخال الملاحظات",
    'description.string'=>"يرجى ادخال الملاحظات بالحروف ",
          ]);

        $product=products::find($id);
        $product->product_name=$request->product_name;
        $product->description=$request->description;
        $product->section_id=$request->section_id;
        $product->save();
        return redirect()->route('index.product')->with("done","تم التعديل بنجاح");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(products $products,$id)
    {
        $product=products::find($id);
        $product->delete();
        return redirect()->route('index.product')->with("done","تم الحذف بنجاح");
    }
}
