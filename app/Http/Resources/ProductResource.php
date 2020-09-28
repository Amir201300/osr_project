<?php

namespace App\Http\Resources;

use App\Models\Like;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $image=$this->Product_images->count() > 0 ? $this->Product_images[0]->image : null;
        $user=$user=auth('api')->user();
        $is_my_product=false;
        if($user){
            $is_my_product=$this->user_id == $user->id ? true : false;
        }
        $is_like=false;
        if($user){
            $like=Like::where('user_id',$user->id)->where('model_id',$this->id)->where('type',2)->first();
            $is_like=!is_null($like) ? true : false;
        }
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'price'   => (int)$this->price,
            'image'   =>getImageUrl('Product_images',$image),
            'desc' => $this->desc,
            'shop_id' =>(int) $this->user_id,
            'cat_name'=>$this->cat ? $this->cat->name : null,
            'cat_id'=>(int)$this->cat_id,
            'number_of_views'=>(int)$this->view,
            'number_of_likes'      =>$this->likes->count(),
            'is_like'      =>$is_like,
            'rate' =>(int) $this->rate,
            'is_my_product'=>$is_my_product,
            'status'=>(int)$this->status,
            'shop_name'=>$this->shop->name,
            'shop_logo'=>getImageUrl('Users',$this->shop->image),
            'images' => Product_imagesResource::collection($this->Product_images),
        ];

    }
}