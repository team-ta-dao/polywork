<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Jobs\ImportJob;
use App\Imports\AdminImportStudent;
use App\Http\Controllers\Controller;

class AdminImportStudentController extends Controller
{
    //
    public function show(){
        return view('pages.import');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        $file = $request->file('file')->store('import');

        $import = new AdminImportStudent;
        $import->import($file);
        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }
        return back()->withStatus('Import dữ liệu thành công');
}
}
