<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator,Auth;
use App\Models\Settings;

class SettingsController extends Controller
{

    //index
    public function index(Request $request)
    {
        return view('manage.Settings.index');
    }

    //View Function
    public function view(Request $request)
    {
        $Settings=Settings::orderBY('created_at','desc')->get();
        return $this->dataFunction($Settings);
    }
    
    //Show Function
    public function show($id)
    {
        $Settings=Settings::find($id);
        if(is_null($Settings))
        {
            return BaseController::Error('Product not exist','الكلمة الدلالية غير موجودة');
        }

        return $Settings;
    }




    // update function
    public function update(Request $request)
    {
        $Settings=Settings::first();
        if(is_null($Settings))
        {
            return response()->json(['errors'=>true]);
        }

        $Settings->our_policy=$request->our_policy;
        $Settings->about_us=$request->about_us;
        $Settings->save();

        return response()->json(['errors'=>false]);

    }
    

    private function dataFunction($data)
    {
        return Datatables::of($data)->addColumn('action' ,function($data){
            $options='<td class="sorting_1"><button  class="btn btn-info waves-effect btn-circle waves-light" onclick="edit('.$data->id.')" type="button" ><i class="fa fa-spinner fa-spin" id="loadEdit_'.$data->id.'" style="display:none"></i><i class="fas fa-edit"></i></button>';
            return $options;
        })->editColumn('our_policy',function($data){
            $our_policy=\Illuminate\Support\Str::limit(strip_tags($data->our_policy),70,'......');
            return $our_policy;
        })->editColumn('about_us',function($data){
            $about_us=\Illuminate\Support\Str::limit(strip_tags($data->about_us),70,'.......');
            return $about_us;
        })->rawColumns(['action' => 'action','checkBox'=>'checkBox',
            'status'=>'status','our_policy'=>'our_policy','about_us'=>'about_us'])->make(true);

    }
}
