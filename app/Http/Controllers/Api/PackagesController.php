<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PackagesResource;
use App\Interfaces\HandleDataInterface;
use App\Models\Packages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth,Artisan,Hash,File,Crypt;

class PackagesController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param HandleDataInterface $data
     * @param Request $request
     * @return mixed
     */
    public function get_Packages(HandleDataInterface $data,Request $request)
    {
        $job =new Packages();
        return $data->getAllData($job,$request,new PackagesResource(null));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function single_Package($id)
    {
        $job = Packages::find($id);
         if (is_null($job))
         {
             $msg = 'الباقه المطلوبه غير موجوده';
             return $this->apiResponseMessage('0',$msg,200);
         }

        $msg = 'تمت العمليه بنجاح';
        return $this->apiResponseData(new PackagesResource($job),$msg,200);
    }


}