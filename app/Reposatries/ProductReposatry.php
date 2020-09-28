<?php

namespace App\Reposatries;

use App\Interfaces\ProductInterface;
use App\Models\Like;
use App\Models\Product_image;
use App\Models\Product_tags;
use App\Models\Rate;
use App\Models\Wishlist;
use Validator, Artisan, Hash, File, Crypt;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReposatry implements ProductInterface
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param $request
     * @param $id
     * @param $admin
     * @return Product|\Illuminate\Http\JsonResponse|mixed
     */
    public function save_or_update($request, $id , $admin=1)
    {

        if ($id != 0) {
            $Product = Product::find($id);
            if (is_null($Product))
                return $this->not_found_v2();
        }else{
            $Product = new Product();
        }
        $Product->name = $request->name;
        $Product->price = $request->price;
        $Product->delivery = $request->delivery;
        if($admin==0)
            $Product->special = $request->special;
        $Product->desc = $request->desc;
        $Product->cat_id = $request->cat_id;
        $Product->user_id = $admin == 0 ? $request->user_id :  Auth::user()->id;
        $Product->status = $id == 0 ? 0 : $Product->status;
        if($admin==0)
            $Product->status = $request->status;
        $Product->save();
        if(isset($request->image) AND $id ==0) {
            for ($i = 0; $i < count($request->image); $i++) {
                $this->upload_product_image($request->image[$i], $Product->id);
            }
        }
        return $Product;
    }

    /**
     * @param $request
     * @param $product_id
     * @param $admin
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|mixed
     */
    public function validate_product($request, $product_id,$admin)
    {
        if($admin != 0) {
            $user = Auth::user();
            if ($user->user_type != 2) {
                $msg = 'عفوا لا يمكنك اضافه منتج';
                return $this->apiResponseMessage(0, $msg, 200);
            }

            $isset_product = $this->isset_product($product_id);
            if (isset($isset_product)) {
                return $isset_product;
            }
        }

        $input = $request->all();
        $validationMessages = [
            'name.required' => 'من فضلك ادخل اسم المنتج  ' ,
            'image.required' =>  'من فضلك ادخل على الاقل صورة واحدة للمنتج',
            'price.double' =>  'سعر المنتج غير صالح' ,
            'price.required' =>  'من فضلك ادخل سعر المنتج' ,
            'price.numeric' => 'سعر المنتج يجب ان يكون رقما' ,
            'cat_id.exists'      =>  'عفوا,هذا القسم غير موجود' ,
            'cat_id.required'      => 'من فضلك ادخل القسم' ,
            'image.between'      => 'الحد الاقصى للصور هو 3 صور' ,
            'image.*.max'=>'يجب ان لا يزيد حجم الصورة عن 2000',
            'image.*.image'=>'ادخل صورة صالحة'
        ];

        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'cat_id'   => 'required|exists:categories,id',
            'image'=> $product_id == 0 ? 'array|required|between:0,3' : '',
            'image.*' => 'image|mimes:jpg,jpeg,png|max:2000'
        ], $validationMessages);


        if ($validator->fails()) {
            return $this->apiResponseMessage(0, $validator->messages()->first(), 200);
        }
    }

    /**
     * @param $image
     * @param $product_id
     * @return array|mixed
     */
    public function upload_product_image($image, $product_id)
    {
        $product_image = new Product_image();
        $product_image->image = saveImage('Product_images', $image);
        $product_image->product_id = $product_id;
        $product_image->save();
        return [$product_image,1];
    }

    /**
     * @param $id
     * @return mixed|void
     */
    public function delete_product_image($id)
    {
        $lang=get_user_lang();
        $image = Product_image::find($id);
        if(is_null($image)){
            $msg=$lang=='ar' ? 'الصورة غير موجودة'  : 'image dose not exist';
            return $this->apiResponseMessage(0,$msg,200);
        }
        $isset_product = $this->isset_product($image->product_id);
        if (isset($isset_product)) {
            return $isset_product;
        }
        deleteFile('Product_images', $image->image);
        $image->delete();
    }

    /**
     * @param $product_id
     * @return \Illuminate\Http\JsonResponse
     */
    private function isset_product($product_id)
    {
        $user=Auth::user();
        if ($product_id != 0) {
            $Product = Product::where('id',$product_id)->where('user_id',$user->id)->first();
            if (is_null($Product))
                return $this->apiResponseMessage(0,'المنتج غير موجود',200);
        }
    }

    /**
     * @param $product_id
     * @param $admin
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed
     */
    public function delete_product($product_id,$admin=1)
    {
        $user=Auth::user();
        $Product = Product::where('id',$product_id);
        if($admin !=0)
            $Product=$Product->where('user_id',$user->id);
        $Product=$Product->first();
        if (is_null($Product)) {
            return $this->apiResponseMessage(0,'المنتج غير موجود',200);
        }
        foreach ($Product->Product_images as $row){
            deleteFile('Product_images',$row->image);
        }
        Rate::where('RateRelation_id',$product_id)->where('RateRelation_type','App\Models\Product')->delete();
        Like::where('model_id',$product_id)->where('type',2)->delete();
        $Product->delete();
        return $this->apiResponseMessage(1,'تم حذف المنتج الخاص بكم بنجاح',200);
    }

    /**
     * @param $product_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed
     */
    public function save_to_wishlist($product_id){
        $user=Auth::user();
        $Product = Product::where('id',$product_id)->where('status',1)->first();
        if (is_null($Product)) {
            return $this->apiResponseMessage(0,'المنتج غير موجود',200);
        }
        $whislist=Wishlist::where('user_id',$user->id)->where('product_id',$product_id)->first();
        if(is_null($whislist)){
            $whislist=new Wishlist();
            $whislist->user_id=$user->id;
            $whislist->product_id=$product_id;
            $whislist->save();
            $msg='تم اضافة المنتج في المفضلات';
        }else{
            $whislist->delete();
            $msg='تم حذف المنتج من المفضلات';
        }
        return $this->apiResponseMessage(1,$msg,200);
    }
}