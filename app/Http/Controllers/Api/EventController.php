<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EventResource;
use App\Interfaces\HandleDataInterface;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth,Artisan,Hash,File,Crypt;

class EventController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param HandleDataInterface $data
     * @param Request $request
     * @return mixed
     */
    public function get_Event(HandleDataInterface $data,Request $request)
    {
        $Event =new Event;
        return $data->getAllData($Event,$request,new EventResource(null));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function single_Event($id)
    {
        $Event = Event::find($id);
        if (is_null($Event))
        {
            $msg = 'الايفنت المطلوب غير موجود';
            return $this->apiResponseMessage('0',$msg,200);
        }
        $msg = 'تمت العمليه بنجاح';
        return $this->apiResponseData(new EventResource($Event),$msg,200);
    }


}