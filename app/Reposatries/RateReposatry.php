<?php

namespace App\Reposatries;

use App\Interfaces\RateInterface;
use App\Models\Like;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Reporting;
use App\User;
use Auth,Validator;

class RateReposatry implements RateInterface {
    use \App\Traits\ApiResponseTrait;

    public function rating( $type, $request,$model,$model_id)
    {
        $data=$model::where('id',$model_id)->where('status',1)->first();
        if(is_null($data))
        {
            return $this->not_found_v2();
        }
        $validate_rate=$this->validate_rate($request);
        if(isset($validate_rate))
        {
            return $validate_rate;
        }
        $msg= $this->save_rate($data,$request,$type);
        $this->cal_rate($data,$request->rate);
        return $this->apiResponseMessage(1,$msg,200);
    }

    /**
     * @param $data
     * @param $request
     * @param $type
     * @param $lang
     * @return string
     */
    private function save_rate($data,$request,$type)
    {
        $user=Auth::user();
        $rate= Rate::where('user_id',$user->id)->where('RateRelation_id',$data->id)->where('RateRelation_type',$type)->first();
        if(is_null($rate))
        {
            $rate=new Rate();
            $rate->rate=$request->rate;
            $rate->comment=$request->comment;
            $rate->user_id=$user->id;
            $rate->RateRelation_id=$data->id;
            $rate->RateRelation_type=$type;
            $rate->save();
            $msg= 'تم اضافة التقييم بنجاح' ;
        }else{
            $rate->rate=$request->rate;
            $rate->comment=$request->comment;
            $rate->save();
            $msg= 'تم تعديل التقييم بنجاح' ;
        }
        return $msg;
    }

    /**
     * @param $data
     * @param $rate
     */
    private function cal_rate($data,$rate)
    {
        if($data->rate == 0)
        {
            $newRate=$rate;
        }else{
            $newRate=($rate + $data->rate) / 2;
        }
        $data->rate=$newRate;
        $data->save();
    }


    private function validate_rate($request)
    {
        $user=Auth::user();
        $input = $request->all();
        $validationMessages = [
            'rate.required' =>  'من فضلك ادخل التقييم' ,
            'rate.integer' =>  'التقييم يجب ان يكون رقما' ,
            'rate.between' =>  'قيمة التقييم يجب ان تكون من 1 الي 5'   ,
        ];

        $validator = Validator::make($input, [
            'rate' => 'required|integer|between:1,5',
        ], $validationMessages);

        if ($validator->fails()) {
            return $this->apiResponseMessage(0,$validator->messages()->first(), 200);
        }

        if($user->user_type != 1){
            return $this->apiResponseMessage(0,'الاعضاء فقط من يمكنهم التقييم',200);
        }
    }

    /**
     * @param $model_id
     * @param $type
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed
     */
    public function likes($model_id, $type)
    {
        $user= Auth::user();
        if(!$user->is_required_type(1)){
            return $this->apiResponseMessage(0,'الاعضاء فقط يمكنهم الاعجاب ',200);
        }
        if($type == 1)
            $model=User::where('id',$model_id)->where('user_type',2)->first();
        if($type==2)
            $model=Product::where('id',$model_id)->where('status',1)->first();
        if(is_null($model)){
            $model_name = $type == 1 ? 'المتجر'  : 'المنتج';
            $msg=$model_name . ' غير موجود';
            return $this->apiResponseMessage(0,$msg,200);
        }
        $like=Like::where('user_id',$user->id)->where('model_id',$model_id)->where('type',$type)->first();
        if(is_null($like)){
            $like=new Like();
            $like->user_id=$user->id;
            $like->model_id=$model_id;
            $like->type=$type;
            $like->save();
            $msg='تم الاعجاب  بنجاح';
        }else{
            $msg='تم الغاء  الاعجاب ';
            $like->delete();
        }
        return $this->apiResponseMessage(1,$msg,200);
    }

    /**
     * @param $model_id
     * @param $type
     * @param $comment
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed
     */
    public function reporting($model_id, $type,$comment)
    {
        $user= Auth::user();
        if(!$user->is_required_type(1)){
            return $this->apiResponseMessage(0,'الاعضاء فقط يمكنهم الاعجاب ',200);
        }
        if($type == 1)
            $model=User::where('id',$model_id)->where('user_type',2)->first();
        if($type==2)
            $model=Product::where('id',$model_id)->where('status',1)->first();
        if(is_null($model)){
            $model_name = $type == 1 ? 'المتجر'  : 'المنتج';
            $msg=$model_name . ' غير موجود';
            return $this->apiResponseMessage(0,$msg,200);
        }

        $Reporting = new Reporting();
        $Reporting->user_id = $user->id;
        $Reporting->model_id = $model_id;
        $Reporting->type = $type;
        $Reporting->comment = $comment;
        $Reporting->save();
            $msg='تم تقديم البلاغ وسيقوم فريقنا بالرد عليكم في اقرب وقت';
        return $this->apiResponseMessage(1,$msg,200);
    }

}