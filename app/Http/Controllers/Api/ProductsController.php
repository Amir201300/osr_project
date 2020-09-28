<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RateResource;
use App\Interfaces\HandleDataInterface;
use App\Interfaces\ProductInterface;
use App\Interfaces\RateInterface;
use App\Models\Product;
use App\Models\Reporting;
use App\Reposatries\HandleDataReposatry;
use Illuminate\Http\Request;
use Auth;

class ProductsController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @param ProductInterface $product
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function add_product(Request $request, ProductInterface $product)
    {
        $validate = $product->validate_product($request, 0,1);
        if (isset($validate)) {
            return $validate;
        }
        $saved_product = $product->save_or_update($request, 0,1);
        $msg = 'تم اضافه المنتج بنجاح بانتظار موافقة المدير';
        return $this->apiResponseData(new ProductResource($saved_product), $msg, 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @param ProductInterface $product
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function edit_product($id, Request $request, ProductInterface $product)
    {
        $validate = $product->validate_product($request, $id,1);
        if (isset($validate)) {
            return $validate;
        }
        $saved_product = $product->save_or_update($request, $id,1);
        $msg = 'تم تعديل المنتج بنجاح ';
        return $this->apiResponseData(new ProductResource($saved_product), $msg, 200);
    }

    /**
     * @param HandleDataReposatry $dataReposatry
     * @param Request $request
     * @return array|mixed
     */
    public function my_products(HandleDataReposatry $dataReposatry, Request $request)
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id);
        return $dataReposatry->getAllData($products, $request, new ProductResource(null));
    }

    /**
     * @param HandleDataReposatry $dataReposatry
     * @param $product_id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function single_product(HandleDataReposatry $dataReposatry, $product_id)
    {
        $product = Product::where('id', $product_id)->where('status', 1)->get();
        if(is_null($product)){
            return $this->apiResponseMessage(0,'المنتج غير موجود',200);
        }
        $product->view = $product->view + 1;
        $product->save();
        $other_products=Product::where('user_id',$product->user_id)->where('status',1)->where('id','!=',$product_id)->take(6)->get();
        $data=[
          'product_details'=>new ProductResource($product),
            'other_products'=>ProductResource::collection($other_products)
        ];
        return $this->apiResponseData($data,'تمت العملية بنجاح',200);
    }

    /**
     * @param $product_id
     * @param ProductInterface $product
     * @return mixed
     */
    public function delete_product($product_id, ProductInterface $product)
    {
        return $product->delete_product($product_id,1);
    }

    /**
     * @param $product_id
     * @param Request $request
     * @param RateInterface $rate
     * @return mixed
     */
    public function save_my_rate($product_id, Request $request, RateInterface $rate)
    {
        return $rate->rating('App\Models\Product', $request, new Product, $product_id);
    }

    /**
     * @param $product_id
     * @param ProductInterface $product
     * @return mixed
     */
    public function save_to_wishlist($product_id, ProductInterface $product)
    {
        return $product->save_to_wishlist($product_id);
    }

    /**
     * @param $product_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function get_product_rates($product_id)
    {
        $product = Product::where('id', $product_id)->where('status', 1)->first();
        if (is_null($product)) {
            return $this->apiResponseMessage(0, 'المنتج غير موجود', 200);
        }
        return $this->apiResponseData(RateResource::collection($product->rateRelation), 'تمت العملية بنجاح', 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function my_wishlist(){
        $user=Auth::user();
        return $this->apiResponseData(ProductResource::collection($user->whislist),'تمت العملية بنجاح',200);
    }

    /**
     * @param Request $request
     * @param HandleDataInterface $handleData
     * @return mixed
     */
    public function all_products(Request $request,HandleDataInterface $handleData)
    {
        $product=Product::where('status',1);
        return $handleData->getAllData($product,$request,new ProductResource(null));
    }


    /**
     * @param $product_id
     * @param RateInterface $rate
     * @return mixed
     */
    public function likeOrUnlike($product_id, RateInterface $rate)
    {
        return $rate->likes($product_id, 2);
    }

    /**
     * @param $product_id
     * @param RateInterface $rate
     * @param Request $request
     * @return mixed
     */
    public function reporting($product_id, RateInterface $rate,Request $request)
    {
        return $rate->reporting($product_id, 2,$request->comment);
    }

}