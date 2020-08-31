<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator,Auth;
use App\Models\Contact_us;

class Contact_usController extends Controller
{

    //index
    public function index(Request $request)
    {
        $type=$request->type;
        return view('manage.Contact_us.index',compact('type'));
    }

    //View Function
    public function view(Request $request)
    {
        $Contact_us=Contact_us::orderBY('created_at','desc')->where('type',$request->type)->get();
        return $this->dataFunction($Contact_us);
    }


    //Show Function
    public function show($id)
    {
        $Contact_us=Contact_us::find($id);
        if(is_null($Contact_us))
        {
            return BaseController::Error('Product not exist','الكلمة الدلالية غير موجودة');
        }

        return $Contact_us;
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
            $Ads=Contact_us::whereIn('id',$ids)->delete();
        }else{
            $Ads=Contact_us::find($id);
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
        })->editColumn('status',function($data){
            $status='<button class="btn waves-effect waves-light btn-rounded btn-success statusBut">'.trans('main.Active').'</button>';
            if($data->status == 0)
                $status='<button class="btn waves-effect waves-light btn-rounded btn-danger statusBut">'.trans('main.inActive').'</button>';
            return $status;
        })->rawColumns(['action' => 'action','checkBox'=>'checkBox','status'=>'status'])->make(true);

    }
}
