<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class SectionsController extends Controller
{

    public function index()
    {
        $section=sections::all();
        return view('sections.index')->with('section',$section);
    }


    public function create()
    {

    }


    public function store(Request $request)
    {

        // $input=$request->all();
        // $b_exit=sections::where('section_name','=',$input['section_name'])->exists();
        // if($b_exit){
        //    return redirect()->back()->with("done","مسجل بالفعل");
        // }else{}

            $request->validate([               // لا يتكرر الاسم داخل الداتا بيز
                'section_name'=>'required|string|unique:sections',
                'description'=>'required|string',
              ],[

        'section_name.required'=>"يرجى ادخال اسم القسم",
        'section_name.string'=>"يرجى ادخال الاسم بالحروف ",
        'section_name.unique'=>"القسم مسجل بالفعل",
        'description.required'=>"يرجى ادخال الملاحظات",
        'description.string'=>"يرجى ادخال الملاحظات بالحروف "
              ]);

        $section= new sections();
        $section->section_name=$request->section_name;
        $section->description=$request->description;
        $section->created_by= Auth::user()->name;
        $section->save();
        return redirect()->back()->with("done","تم اضافه القسم بنجاح");

     }


    public function show(sections $sections)
    {

    }


    public function edit($id)
    {
        $section=sections::find($id);
        return view('sections.edit')->with("section",$section);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'section_name'=>'required|string',
            'description'=>'required|string',
          ],[

    'section_name.required'=>"يرجى ادخال اسم القسم",
    'section_name.string'=>"يرجى ادخال الاسم بالحروف ",
    'description.required'=>"يرجى ادخال الملاحظات",
    'description.string'=>"يرجى ادخال الملاحظات بالحروف "
          ]);
    $section=sections::find($id);
    $section->section_name=$request->section_name;
    $section->description=$request->description;
    $section->created_by= Auth::user()->name;
    $section->save();
    return redirect()->route('index.section')->with("done","تم التعديل بنجاح");
    }

    public function destroy(sections $sections,$id)
    {
        $section=sections::find($id);
        $section->delete();
        return redirect()->route('index.section')->with("done","تم الحذف بنجاح");
    }
}
