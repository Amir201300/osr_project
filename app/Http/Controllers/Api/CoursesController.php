<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CoursesResource;
use App\Interfaces\HandleDataInterface;
use App\Models\Cources;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth,Artisan,Hash,File,Crypt;

class CoursesController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param HandleDataInterface $data
     * @param Request $request
     * @return mixed
     */
    public function get_Courses(HandleDataInterface $data,Request $request)
    {
        $courses =new Cources();
        return $data->getAllData($courses,$request,new CoursesResource(null));
    }

}