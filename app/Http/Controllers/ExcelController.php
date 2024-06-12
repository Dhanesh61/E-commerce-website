<?php
namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel as ExcelFacade;
use App\Http\Imports\ExcelImport;
use App\Models\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExcelController extends Controller
{
    public function excel()
    {
        return view('excel.exceldata');
    }

        public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->withErrors(['file' => 'Please upload a valid file.']);
        }

        $import = new ExcelImport;
        ExcelFacade::import($import, $request->file('file'));

        $errors = $import->getErrors();
        if (!empty($errors)) {
            $formattedErrors = [];
            foreach ($errors as $index => $error) {
                $rowNumber = $index + 2;
                $formattedErrors["Row {$rowNumber}"] = $error['errors'];
            }
            return redirect()->back()->withErrors($formattedErrors)->withInput();
        } else {
            return redirect()->back()->with('success', 'File uploaded and data imported successfully.');
        }
    }

    public function adminexcel(){
        $excels = Excel::all();
        return view('excel.adminexcel',compact('excels'));
    }
}
