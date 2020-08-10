<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoriesResource;
use App\Http\Controllers\Controller;
use App\Interfaces\HandleDataInterface;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param HandleDataInterface $data
     * @param Request $request
     * @return mixed
     */
    public function main_categories(HandleDataInterface $data, Request $request)
    {
        $main_Categories = Category::where('parent_id', 0)->where('status', 1);
        return $data->getAllData($main_Categories, $request, new CategoriesResource(null));
    }

    /**
     * @param HandleDataInterface $data
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function sup_categories(HandleDataInterface $data, Request $request, $parent_id)
    {
        $sup_categories = Category::where('parent_id', $parent_id)->where('status', 1);
        return $data->getAllData($sup_categories, $request, new CategoriesResource(null));
    }
}