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

}