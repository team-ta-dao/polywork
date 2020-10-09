<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Http\Controllers\Controller;
use App\Job_Benefit;
use App\Job_level;
use App\JobBenefit;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Render to add new post view
     * 
     * @return route
     */
    public function addPostView()
    {
        return view('pages.post.add-new-post');
    }

    /**
     * Get Offer from DB to view
     * 
     * @return array list of offer
     */
    public function getOffer()
    {
        $job_benefit = JobBenefit::all();
        // $company = Company::find(3);

        echo json_encode($job_benefit);
    }
}
