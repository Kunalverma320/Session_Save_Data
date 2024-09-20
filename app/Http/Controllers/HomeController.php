<?php

namespace App\Http\Controllers;

use App\Imports\FormDataImport;
use App\Models\Formdata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function index()
    {
        // dd(Session::get('formData'));
        // Session::forget('formData');
        return view('welcome');
    }
    public function formdata(Request $request)
    {

        $validatedData = $request->validate([
            'Name' => 'required|string|max:255',
            'Password' => 'required|min:8',
            'Email' => 'required|email|max:255',
            'Image' => 'required',
            'Mobile' => 'required|digits:10',
            'Date' => 'required|date',
            'Role' => 'required',
        ]);
        $filepath=null;
        if ($request->hasFile('Image')) {
            $filepath = $request->file('Image')->store('uploads', 'public');
            $validatedData['Image'] = $filepath;
        }


        $formData = Session::get('formData', []);
        $next_id=count($formData)+1;
        $formData[$next_id]=array_merge($validatedData,['Image',$filepath]);
        Session::put('formData', $formData);
        return back()->with([
            'success' => 'Form submitted successfully!'
        ]);

    }
    public function formdata_edit($id)
    {
        $formdata=Session::get('formData',[]);
        $record=$formdata[$id] ?? null;
        return view('formedit',['record'=>$record,'id'=>$id]);
    }
    public function formdata_edit_save(Request $request,$id)
    {
        $validatedData = $request->validate([
            'Name' => 'required|string|max:255',
            'Password' => 'required|min:8',
            'Email' => 'required|email|max:255',
            'Image' => 'nullable|Image',
            'Mobile' => 'required|digits:10',
            'Date' => 'required|date',
            'Role' => 'required',
        ]);
        $filepath=null;
        if ($request->hasFile('Image')) {
            $filepath = $request->file('Image')->store('uploads', 'public');
            $validatedData['Image'] = $filepath;
        }


        $formData = Session::get('formData', []);

        $formData[$id]=array_merge($validatedData,['Image',$filepath]);
        Session::put('formData', $formData);
        return redirect('/')->with([
            'success' => 'Form Updated successfully!'
        ]);
    }
    public function formdata_delete($id)
    {
        $formdata=Session::get('formData',[]);
        unset($formdata[$id]);
        Session::put('formData',$formdata);
        return redirect('/')->with('success', 'Record deleted successfully!');
    }
    public function finalsubmit()
    {
        $formdata=Session::get('formData',[]);
        foreach ($formdata as $data) {
            FormData::create([
                'Name' => $data['Name'],
                'Password' => $data['Password'],
                'Email' => $data['Email'],
                'Image' => $data['Image'],
                'Mobile' => $data['Mobile'],
                'Date' => $data['Date'],
                'Role' => $data['Role'],
            ]);
        }
        Session::forget('formData');
        return redirect('/')->with('success', 'Record Submited successfully!');
    }

    public function csvupload(Request $request)
    {

        try{
            // dd($request->file('csvupload'));
            Excel::import(new FormDataImport, $request->file('csvupload'));
            return redirect('/')->with('success', 'Record Imported successfully!');
        }catch(\Exception $ex){
            Log::info($ex);
            return response()->json(['data'=>'Some error has occur.',400]);

        }
    }

}
