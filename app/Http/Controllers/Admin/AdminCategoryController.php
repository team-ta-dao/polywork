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
    public function index(Request $request)
    {
   
        if ($request->ajax()) {
            $data = Job_category::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editCategory">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteCategory">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('pages.category',compact('Job_category'));
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
    public function edit($id)
    {
        $category = Job_category::find($id);
        return response()->json($category);
    }
    public function destroy($id)
    {
        Job_category::find($id)->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
