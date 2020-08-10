<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AdvicesResource;
use App\Http\Resources\CityResource;
use App\Interfaces\HandleDataInterface;
use App\Models\Advices;
use App\Models\Area;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth,Artisan,Hash,File,Crypt;

class General_infoController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param HandleDataInterface $data
     * @param Request $request
     * @return mixed
     */
    public function get_cities(HandleDataInterface $data,Request $request)
    {
        $city=City::where('status',1);
        return $data->getAllData($city,$request,new CityResource(null));
    }

    /**
     * @param HandleDataInterface $data
     * @param Request $request
     * @param $city_id
     * @return mixed
     */
    public function get_area(HandleDataInterface $data,Request $request,$city_id)
    {
        $city=Area::where('status',1)->where('city_id',$city_id);
        return $data->getAllData($city,$request,new CityResource(null));
    }

    /**
     * @param HandleDataInterface $data
     * @param Request $request
     * @return mixed
     */
    public function get_Advices(HandleDataInterface $data,Request $request)
    {
        $Advices=Advices::where('status',1);
        return $data->getAllData($Advices,$request,new AdvicesResource(null));
    }

}