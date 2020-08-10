<?php

namespace App\Http\Controllers\Manage;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator,Auth;
use App\Models\Area;

class AreaController extends Controller
{

    //index
    public function index(Request $request)
    {
        $cities=City::all();
        return view('manage.Area.index',compact('cities'));
    }

    //View Function
    public function view(Request $request)
    {
        $Area=Area::orderBY('created_at','desc')->get();
        return $this->dataFunction($Area);
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
                'name' => 'required|unique:areas|min:3',
                'city_id' => 'required',
            ],
            [
                'name.required' => 'من فضلك ادخل اسم المنطقة',
                'name.unique' => 'هذا الاسم مسجل لدينا منطقة اخرى',
                'name.min' => 'يجب ان لا يقل عدد حروف اسم لمنطقة عن ثلاثة احرف',
                'city_id.required'=>'من فضلكادخل المحافظة التابعه لها'
            ]

        );

        $Area=new Area;
        $Area->status=$request->status;
        $Area->name=$request->name;
        $Area->city_id=$request->city_id;
        $Area->save();
        return response()->json(['errors'=>false]);
    }

    //Show Function
    public function show($id)
    {
        $Area=Area::find($id);
        if(is_null($Area))
        {
            return response()->json(['errors'=>true]);
        }

        return $Area;
    }




    // update function
    public function update(Request $request)
    {
        $Area=Area::find($request->id);
        if(is_null($Area))
        {
            return response()->json(['errors'=>true]);
        }
        $this->validate(
            $request,
            [
                'name' => 'required|unique:areas,name,'.$request->id.'|min:3',
            ],
            [
                'name.required' => 'من فضلك ادخل اسم المنطقة',
                'name.unique' => 'هذا الاسم مسجل لدينا منطقة اخرى',
                'name.min' => 'يجب ان لا يقل عدد حروف اسم المنطقة عن ثلاثة احرف'
            ]

        );
        $Area->status=$request->status;
        $Area->city_id=$request->city_id;
        $Area->name=$request->name;
        $Area->save();

        return response()->json(['errors'=>false]);

    }


    public function delete(Request $request,$id)
    {
        if($request->type==2)
        {
            $ids=explode(',',$id);
            $Ads=Area::whereIn('id',$ids)->delete();
        }else{
            $Ads=Area::find($id);
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
        })->editColumn('city_id',function($data){
            return $data->city->name;
        })->rawColumns(['action' => 'action','checkBox'=>'checkBox','status'=>'status','city_id'=>'city_id'])->make(true);
    }
}
