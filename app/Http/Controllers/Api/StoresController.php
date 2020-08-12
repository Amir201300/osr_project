<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServicesResource;
use App\Http\Resources\StoreResource;
use App\Models\User_services;
use App\Reposatries\HandleDataReposatry;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\store_info;

class StoresController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function add_service(Request $request)
    {
        $user = Auth::user();
        $user_type = $user->user_type;
        if ($user_type != 2) {
            $msg = 'عفوا لايمنكم اضافه خدمات';
            return $this->apiResponseMessage('0', $msg, 200);
        }
        $service = new User_services();
        $service->name = $request->name;
        $service->user_id = $user->id;
        $service->save();
        $msg = 'تم اضافه الخدمه بنجاح';

        return $this->apiResponseData(ServicesResource::collection($user->services), $msg, 200);
    }

    /**
     * @param $service_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function delete_service($service_id)
    {
        $user = Auth::user();
        $service =User_services::where('id',$service_id)->where('user_id',$user->id)->first();
        if(is_null($service)){
            return $this->apiResponseMessage(0,'الخدمة غير موجودة',200);
        }
        $service->delete();
        return $this->apiResponseData(ServicesResource::collection($user->services), 'تم الحذف بنجاح', 200);
    }

    /**
     * @param Request $request
     * @param HandleDataReposatry $dataReposatry
     * @return array|mixed
     */
    public function get_stores(Request $request,HandleDataReposatry $dataReposatry)
    {
        $stores = User::where('user_type',2)->where('status',1);
        return $dataReposatry->getAllData($stores,$request,new StoreResource(null));
    }

    /**
     * @param Request $request
     * @param HandleDataReposatry $dataReposatry
     * @return array|mixed
     */
    public function single_store(Request $request,HandleDataReposatry $dataReposatry,$user_id)
    {
        $stores = User::where('user_type',2)->where('id',$user_id)->where('status',1)->first();
        return $dataReposatry->getSingleData($stores,$request,new StoreResource(null));
    }

    /**
     * @param Request $request
     * @param HandleDataReposatry $dataReposatry
     * @return array|mixed
     */
    public function search(Request $request,HandleDataReposatry $dataReposatry)
    {
        $stores = User::where('user_type',2)->where('status',1);
        if($request->type == 1)
            $stores=$stores->where('name','LIKE','%' . $request->name .'%');
        if($request->type ==2)
            $stores=$stores->where('city_id',$request->city_id);

        return $dataReposatry->getAllData($stores,$request,new StoreResource(null));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
       $store_info = store_info::where('user_id',$user->id)->first();

        $store_info->user_id = $user->id;
        $store_info->facebook = $request->facebook;
        $store_info->whatsapp = $request->whatsapp;
        $store_info->youtube = $request->youtube;
        $store_info->twitter = $request->twitter;
        $store_info->snap = $request->snap;
        $store_info->instagram = $request->instagram;
        $store_info->about_info = $request->about_info;
        if($request->cover_photo){
            deleteFile('Users',$store_info->cover_photo);
            $store_info->cover_photo=saveImage('Users',$request->cover_photo);
        }
        $store_info->save();
        return $this->apiResponseData(new StoreResource($user),'تم التعديل بنجاح',200);
    }
}