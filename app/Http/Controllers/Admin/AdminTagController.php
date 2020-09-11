<?php

namespace App\Http\Controllers\Admin;

use App\Skill_tag;
use App\Job_category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $categories = Job_category::all();
        if ($request->ajax()) {
            $data = Skill_tag::with('TagOfCategory');
            return Datatables::of($data)
                        ->editColumn('TagOfCategory', function($data)
                        {
                        return $data->TagOfCategory->name;
                        })                    
                        ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editTag">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteTag">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('pages.tag', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validation = Validator::make($request->all(), [
            'tag_name'=> 'required',
        ]);
        $error_array = array();
        $success_output = '';
        if ($validation->fails())
        {
            foreach ($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages; 
                return response()->json(['error'=>$error_array]);
            }
        }
        if($request->button_action == 'insert'){
            $skillTag = Skill_tag::query()->where('st_name',$request->tag_name)->where('jc_id',$request->category_name)->first();
            if(!empty($skillTag)){
                return response()->json(['error'=>'Dữ liệu của bạn đã có tag name '. $request->tag_name .' này rồi ']);
            }
            Skill_tag::updateOrCreate(
            ['id' => $request->tag_id],
            ['st_name' => $request->tag_name,'jc_id'=>$request->category_name,'st_slug' =>str_slug($request->tag_name,'-')]);
            return response()->json(['success'=>'Category saved successfully.']);
        }else{
            Skill_tag::updateOrCreate(
            ['id' => $request->tag_id],
            ['st_name' => $request->tag_name,'jc_id'=>$request->category_name,'st_slug' =>str_slug($request->tag_name,'-')]);
            return response()->json(['success'=>'Category saved successfully.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $tag = Skill_tag::query()->where('id',$id)->first();
        $cate = Job_category::query()->where('id',$tag->jc_id)->first();
        return response()->json(['name'=>$cate->name,'st_name'=>$tag->st_name,'id'=>$tag->id,'cat_id'=>$cate->id,]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Skill_tag::find($id)->delete();
        return response()->json(['success'=>'Tag deleted successfully.']);
    }
}
