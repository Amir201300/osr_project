<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SliderResource;
use App\Interfaces\HandleDataInterface;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Reposatries\HandleDataReposatry;
use Illuminate\Http\Request;
use Auth,DB;

class HomeController extends Controller
{
    use \App\Traits\ApiResponseTrait;



    /**
     * @param HandleDataReposatry $dataReposatry
     * @param $product_id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function home()
    {
        $user=Auth::user();
        $products=Product::where('status',1)->whereHas('shop',function($q)use ($user){
            $q->where('city_id',$user->city_id);
        })->take(6)->get();
        $slider=Slider::where('status',1)->whereDate('expire_date','>',now())->whereDate('start_date','<=',now())
            ->orderBy('order','asc')->get();
        $cats=Category::where('status',1)->where('parent_id',0)->take(8)->get();
        $data=[
            'products'=>ProductResource::collection($products),
            'Sliders'=>SliderResource::collection($slider),
            'cats'=>CategoriesResource::collection($cats)
        ];
        return $this->apiResponseData($data,'تمت العملية بنجاح',200);
    }

    /**
     * @param $cat_id
     * @param Request $request
     * @param HandleDataInterface $HandleDataInterface
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed
     */
    public function product_by_cat($cat_id,Request $request,HandleDataInterface $HandleDataInterface){
        $user=Auth::user();
        $products=Product::where('status',1)->where('cat_id',$cat_id);
        if($request->type == 1){
            $products=$products->whereHas('shop',function($q)use ($user){
               $q->where('city_id',$user->city_id);
            });
        }
        if($request->type ==2){
            if(!$request->lat OR !$request->lng){
                return $this->apiResponseMessage(0,'من فضلك ارسل خط الطول وخط العرض',200);
            }
            $products=$products->whereHas('shop',function($q)use ($request){
                $q->select(DB::raw('*, ( 6367 * acos( cos( radians('.$request->lat.') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('.$request->lng.') ) + sin( radians('.$request->lat.') )* sin( radians( lat ) ) ) ) AS distance'))
                    ->having('distance', '<', 100)
                    ->orderBy('distance');
            });
        }

        if($request->type == 3){
            $products=$products->where('special',1);
        }
        return $HandleDataInterface->getAllData($products,$request,new ProductResource(null));
    }



}