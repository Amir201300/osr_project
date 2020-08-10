<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator,Auth;
use App\Models\Advices;

class AdvicesController extends Controller
{

    //index
    public function index(Request $request)
    {
        return view('manage.Advices.index');
    }

    //View Function
    public function view(Request $request)
    {
        $Advices=Advices::orderBY('created_at','desc')->get();
        return $this->dataFunction($Advices);
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
                'answer' => 'required',
                'question' => 'required'
            ],
            [
                'answer.required' => 'من فضلك ادخل المحتوى',
                'question.required' => 'من فضلك ادخل العنوان',
            ]

        );
        $Advices=new Advices;
        $Advices->status=$request->status;
        $Advices->answer=$request->answer;
        $Advices->question=$request->question;
        $Advices->save();
        return response()->json(['errors'=>false]);
    }

    //Show Function
    public function show($id)
    {
        $Advices=Advices::find($id);
        if(is_null($Advices))
        {
            return BaseController::Error('Product not exist','الكلمة الدلالية غير موجودة');
        }

        return $Advices;
    }




    // update function
    public function update(Request $request)
    {
        $Advices=Advices::find($request->id);
        if(is_null($Advices))
        {
            return response()->json(['errors'=>true]);
        }
        $this->validate(
            $request,
            [
                'answer' => 'required',
                'question' => 'required'
            ],
            [
                'answer.required' => 'من فضلك ادخل المحتوى',
                'question.required' => 'من فضلك ادخل العنوان',
            ]

        );
        $Advices->status=$request->status;
        $Advices->answer=$request->answer;
        $Advices->question=$request->question;
        $Advices->save();

        return response()->json(['errors'=>false]);

    }


    public function delete(Request $request,$id)
    {
        if($request->type==2)
        {
            $ids=explode(',',$id);
            $Ads=Advices::whereIn('id',$ids)->delete();
        }else{
            $Ads=Advices::find($id);
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
        })->editColumn('question',function($data){
            $question=strip_tags($data->question);
            return $question;
        })->editColumn('answer',function($data){
            $answer=strip_tags($data->answer);
            return $answer;
        })->rawColumns(['action' => 'action','checkBox'=>'checkBox',
            'status'=>'status','question'=>'question','answer'=>'answer'])->make(true);

    }
}
