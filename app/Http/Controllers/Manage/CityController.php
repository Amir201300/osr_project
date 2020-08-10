<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator,Auth;
use App\Models\City;

class CityController extends Controller
{

    //index
    public function index(Request $request)
    {
        return view('manage.City.index');
    }

   //View Function
        public function view(Request $request)
    {
        $City=City::orderBY('created_at','desc')->get();
        return $this->dataFunction($City);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|unique:cities|min:3',
            ],
            [
                'name.required' => 'من فضلك ادخل اسم المحافظة',
                'name.unique' => 'هذا الاسم مسجل لدينا لمحافظة اخرى',
                'name.min' => 'يجب ان لا يقل عدد حروف اسم المحافظة عن ثلاثة احرف'
            ]

        );

        $City=new City;
        $City->status=$request->status;
        $City->name=$request->name;
        $City->save();
        return response()->json(['errors'=>false]);
    }

    //Show Function
    public function show($id)
    {
        $City=City::find($id);
        if(is_null($City))
        {
            return BaseController::Error('Product not exist','الكلمة الدلالية غير موجودة');
        }

        return $City;
    }




    // update function
    public function update(Request $request)
    {
        $City=City::find($request->id);
        if(is_null($City))
        {
            return response()->json(['errors'=>true]);
        }
        $this->validate(
            $request,
            [
                'name' => 'required|unique:cities,name,'.$request->id.'|min:3',
            ],
            [
                'name.required' => 'من فضلك ادخل اسم المحافظة',
                'name.unique' => 'هذا الاسم مسجل لدينا لمحافظة اخرى',
                'name.min' => 'يجب ان لا يقل عدد حروف اسم المحافظة عن ثلاثة احرف'
            ]

        );
        $City->status=$request->status;
        $City->name=$request->name;
        $City->save();

        return response()->json(['errors'=>false]);

    }


    public function delete(Request $request,$id)
    {
        if($request->type==2)
        {
            $ids=explode(',',$id);
            $Ads=City::whereIn('id',$ids)->delete();
        }else{
            $Ads=City::find($id);
            if(is_null($Ads))
            {
                return 5;
            }
            $Ads->delete();
        }
        return response()->json(['errors'=>false]);

    }

    public function getImage($id)
    {
        $type=2;
        $array=Ads::find($id);
        return view('manage.Images.index',compact('array','type'));
    }



    private function dataFunction($data)
    {
        return Datatables::of($data)->addColumn('action' ,function($data){
            $options='<td class="sorting_1"><button  class="btn btn-info waves-effect btn-circle waves-light" onclick="edit('.$data->id.')" type="button" ><i class="fa fa-spinner fa-spin" id="loadEdit_'.$data->id.'" style="display:none"></i><i class="fas fa-edit"></i></button>';
            $options.='<button type="button" onclick="deleteFunction('.$data->id.',1)" class="btn btn-danger waves-effect btn-circle waves-light"><i class=" fas fa-trash"></i> </button></td>';
            return $options;
        })->addColumn('checkBox',function ($data){
            $checkBox='<td class="sorting_1">'.
                '<div class="custom-control custom-checkbox">'.
                '<input type="checkbox" class="mybox" id="checkBox_'.$data->id.'" onclick="check('.$data->id.')">'.
                '</div></td>';
            return $checkBox;
        })->editColumn('status',function($data){
            $status='<button class="btn waves-effect waves-light btn-rounded btn-success statusBut">'.trans('main.Active').'</button>';
            if($data->status == 0)
                $status='<button class="btn waves-effect waves-light btn-rounded btn-danger statusBut">'.trans('main.inActive').'</button>';
            return $status;
        })->rawColumns(['action' => 'action','checkBox'=>'checkBox','status'=>'status'])->make(true);

    }
}
