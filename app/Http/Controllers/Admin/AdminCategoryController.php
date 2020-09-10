<?php

namespace App\Http\Controllers\Admin;

use App\Job_category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;
class AdminCategoryController extends Controller
{
    //
    public function __contrust(){

    }
    public function index(){
        if(request()->ajax()){
        $category = Job_category::select('id','name');
        return datatables()->of(Job_category::latest()->get())
        ->addColumn('action',function($category){
            return '<a href="#" class="btn btn-xs btn-primary edit" id="'.$category->id.'"><i class="glyphicon glyphicon-edit"></i> Edit</a><a href="#" class="btn btn-xs btn-danger delete" id="'.$category->id.'"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }
        return view('pages.category');
    }   
    public function show($id)
    {

    }
    public function store(Request $request)
    {
        Job_category::updateOrCreate(
        ['id' => $request->product_id],
        ['name' => $request->category_name, 'slug' =>  str_slug($request->category_name,'-')]);        

        return response()->json(['success'=>'Product saved successfully.']);
    }
    public function update(Request $request, Article $article)
    {

    }
    public function destroy($id)
    {

    }
}
