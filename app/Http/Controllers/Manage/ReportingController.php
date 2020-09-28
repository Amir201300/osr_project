<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator,Auth;
use App\Models\Reporting;

class ReportingController extends Controller
{

    //index
    public function index(Request $request)
    {
        return view('manage.Reporting.index');
    }

    //View Function
    public function view(Request $request)
    {
        $Reporting=Reporting::orderBY('created_at','desc');
        if($request->type)
            $Reporting=$Reporting->where('type',$request->type)->get();
        return $this->dataFunction($Reporting);
    }


    //Show Function
    public function show($id)
    {
        $Reporting=Reporting::find($id);
        if(is_null($Reporting))
        {
            return BaseController::Error('Product not exist','الكلمة الدلالية غير موجودة');
        }

        return $Reporting;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function delete(Request $request,$id)
    {
        if($request->type==2)
        {
            $ids=explode(',',$id);
            $Ads=Reporting::whereIn('id',$ids)->delete();
        }else{
            $Ads=Reporting::find($id);
            if(is_null($Ads))
            {
                return 5;
            }
            $Ads->delete();
        }
        return response()->json(['errors'=>false]);

    }


    private function dataFunction($data)
    {
        return Datatables::of($data)->addColumn('action' ,function($data){
            $options = ' <td class="sorting_1"><button title="الرسالة" class="btn btn-success waves-effect btn-circle waves-light" onclick="showData(' . $data->id . ')" type="button" ><i class="fa fa-spinner fa-spin" id="loadShow_' . $data->id . '" style="display:none"></i><i class="fas fa-eye"></i></button>';
            $options.='<button type="button" onclick="deleteFunction('.$data->id.',1)" class="btn btn-danger waves-effect btn-circle waves-light"><i class=" fas fa-trash"></i> </button></td>';
            return $options;
        })->addColumn('checkBox',function ($data){
            $checkBox='<td class="sorting_1">'.
                '<div class="custom-control custom-checkbox">'.
                '<input type="checkbox" class="mybox" id="checkBox_'.$data->id.'" onclick="check('.$data->id.')">'.
                '</div></td>';
            return $checkBox;
        })->editColumn('type',function($data){
            $status='<button class="btn waves-effect waves-light btn-rounded btn-success statusBut">متجر</button>';
            if($data->type == 2)
                $status='<button class="btn waves-effect waves-light btn-rounded btn-danger statusBut">منتج</button>';
            return $status;
        })->editColumn('user_id',function($data){
            return '<a onclick="UserInfo(' . $data->user->id . ')" style="color : blue ; cursor:pointer">' . $data->user->name . '</a>';
        })->rawColumns(['action' => 'action','checkBox'=>'checkBox','type'=>'type','user_id'=>'user_id'])->make(true);

    }
}
