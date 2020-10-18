<?php
namespace App\Http\Controllers\Admin;

use App\Job_Offer;
use App\JobBenefit;
use Illuminate\Support\Facades\DB;

class JobPostController{
    public function index()
    {
        $test = JobBenefit::all();

        return view('pages.post.add-new-post')->withJobBenefit($test);
    }
}