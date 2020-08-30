<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\JobsResource;
use App\Interfaces\HandleDataInterface;
use App\Models\Jobs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth,Artisan,Hash,File,Crypt;

class JobsController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param HandleDataInterface $data
     * @param Request $request
     * @return mixed
     */
    public function get_jobs(HandleDataInterface $data,Request $request)
    {
        $job =new Jobs;
        return $data->getAllData($job,$request,new JobsResource(null));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function single_job($id)
    {
        $job = Jobs::find($id);
         if (is_null($job))
         {
             $msg = 'الوظيفه المطلوبه غير موجوده';
             return $this->apiResponseMessage('0',$msg,200);
         }
         $msg = 'تمت العمليه بنجاح';
        return $this->apiResponseData(new JobsResource($job),$msg,200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function jobs_by_city($id)
    {
        $jobs_by_city = Jobs::where('city_id',$id)->get();
        $msg = 'تمت العمليه بنجاح';
        return $this->apiResponseData(JobsResource::collection($jobs_by_city),$msg,200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search_by_name(Request $request)
    {
        $jobs_by_city = Jobs::where('name','LIKE','%' . $request->name . '%')->get();
        $msg = 'تمت العمليه بنجاح';
        return $this->apiResponseData(JobsResource::collection($jobs_by_city),$msg,200);
    }

    public function add_job(Request $request)
    {
        $input = $request->all();
        $validationMessages = [
            'name.required'       => 'من فضلك ادخل اسم الوظيفه'  ,
            'name.min'            => 'اسم الوظيفه يجب ان يكون اكثر من 3 حروف'  ,
            'city_id.exists'      =>' المحافظة المدخلة غير موجودة لدينا',
            'city_id.required'      =>'برجاء ادخال محافظه',
            'salary.required'      =>'برجاء راتب الوظيفه',
        ];

        $validator = Validator::make($input, [
            'name'     => 'required|min:3',
            'salary'=> 'required',
            'city_id'=>'required|exists:cities,id',
        ], $validationMessages);

        if ($validator->fails()) {
            return $this->apiResponseMessage(0, $validator->messages()->first(), 200);
        }


        $job = new Jobs();
        $job->name = $request->name;
        $job->desc = $request->desc;
        $job->job_type = $request->job_type;
        $job->email = $request->email;
        $job->phone = $request->phone;
        $job->salary = $request->salary;
        $job->city_id = $request->city_id;
        $job->status = 0;
        $job->image = saveImage('Jobs',$request->image);
        $job->link = $request->link;
        $job->save();
        $msg = 'تمت العمليه بنجاح';
        return $this->apiResponseData(new JobsResource($job),$msg,200);
    }

}