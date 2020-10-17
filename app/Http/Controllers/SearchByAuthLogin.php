<?php

namespace App\Http\Controllers;

use App\Job_category;
use App\Job_Post;
use App\Skill_tag;
use Illuminate\Http\Request;

class SearchByAuthLogin extends Controller
{
    //
    public function searchBySkillTag($slug)
    {
        $checkSlug = Skill_tag::where('st_slug', '=', $slug)->first();
        if ($checkSlug) {
            $id = $checkSlug->id;
            $output = Job_Post::with('job_type')->with('job_level')->with('postOfCompany')->with('postSkillTag')->with('job_category')
                ->whereHas('postSkillTag', function ($query) use ($id) {
                    $query->where('skill_tag_id', $id);
                })
                ->get();
            return response()->json(['response' => $output], 200);
        } else {
            return response()->json(['error' => 'Not Found'], 404);
        }
    }
    public function searchByCategory($slug)
    {
        $checkSlug = Job_category::where('slug', '=', $slug)->first();
        if ($checkSlug) {
            $id = $checkSlug->id;
            $output = Job_Post::with('job_type')->with('job_level')->with('postOfCompany')->with('postSkillTag')
                ->with('job_category')->where('jc_id', '=', $id)->get();
            return response()->json(['response' => $output], 200);
        } else {
            return response()->json(['error' => 'Not Found'], 404);
        }
    }
    public function searchFullText(Request $request)
    {
        $output = Job_Post::search($request->get('query'))
        ->with('job_type')->with('job_level')->with('postOfCompany')->with('postSkillTag')
        ->get();
        return response()->json(['response' => $output], 200);
    }
}
