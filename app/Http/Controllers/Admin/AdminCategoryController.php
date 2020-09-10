<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use App\Job_category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class AdminCategoryController extends Controller
{
    //
    public function __contrust(){

    }
    public function index(){
        return view('pages.category');
    }
    public function getdate(){
        $category = Job_category::select('id','name');
        return Datatables::of($category)
        ->addColumn('action',function($category){
            return '<a href="#" class="btn btn-xs btn-primary edit" id="'.$category->id.'"><i class="glyphicon glyphicon-edit"></i> Edit</a><a href="#" class="btn btn-xs btn-danger delete" id="'.$category->id.'"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }   
    public function show($id)
    {

    }
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'category_name' => 'required'
        ]);
        $error_array = array();
        $success_output = "";
        if($validation->fails()){
            foreach($validation->messages()->getMessages() as $field_name => $messages){
                $error_array[] = $messages; 
            }
        }else{
            if($request->button_action == 'insert'){
                $category = new Job_category([
                    'name' => $request->category_name,
                    'slug' => str_slug($request->category_name,'-')
                ]);
            }
            $category->save();
            $success_output = '<div class="alert alert-success">Data Inserted</div>';
        }
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        echo json_encode($output);
    }
    public function update(Request $request, Article $article)
    {

    }
    public function destroy($id)
    {

    }
}
