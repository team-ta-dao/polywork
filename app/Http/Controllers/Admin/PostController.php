<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Company;
use App\Http\Controllers\Controller;
use App\Job_Benefit;
use App\Job_category;
use App\Job_level;
use App\JobBenefit;
use App\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Validator;

class PostController extends Controller
{
    /**
     * Render to add new post view
     * 
     * @return route
     */
    public function addPostView()
    {
        $job_benefit = DB::table('job_benefit')->get();
        $all_company = DB::table('company')->select('id', 'name')->orderBy('name', 'desc')->get();
        $all_category = Job_category::all();
        $job_level = Job_level::all();

        return view('pages.post.add-new-post')->with('jobBenefit', $job_benefit)->with('company', $all_company)->withCategory($all_category)->withJobLevel($job_level);
    }

    /**
     * Get Offer from DB to view
     * 
     * @return array list of offer
     */
    public function getOffer()
    {
    }

    /**
     * get specific company information
     * 
     * @param int company_id
     * @return array list of company value
     */
    public function getCompanyInfo()
    {
        $id = $_POST['companyId'];

        $company = Company::find($id);
        $company_cat = DB::table('company')->where('company.id', $id)->join('job_category', 'company.jc_id', '=', 'job_category.id')->select('company.name', 'company.avatar', 'company.cover_img', 'company.desc', 'company.address', 'job_category.name')->get();
        echo $company_cat;
    }

    protected function storePost(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            // 'jp_title' => 'required'
        ]);

        if ($validatedData->passes()) {
            // JobPost::create($request->all());
            echo json_encode($request->all());
        } else {
            return response()->json(['error'=>$validatedData->errors()->all()]);
        }

        return json_encode([
            'status_code' => 200
        ]);
    }
}
