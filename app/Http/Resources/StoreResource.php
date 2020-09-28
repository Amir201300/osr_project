<?php

namespace App\Http\Resources;

use App\Models\Like;
use Illuminate\Http\Resources\Json\JsonResource;
use Auth;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user=$user=auth('api')->user();
        $is_like=false;
        if($user){
            $like=Like::where('user_id',$user->id)->where('model_id',$this->id)->where('type',1)->first();
            $is_like=!is_null($like) ? true : false;
        }
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'phone'     => $this->phone,
            'email'     => $this->email,
            'image'     => getImageUrl('Users',$this->image),
            'city'      =>$this->city ? $this->city->name : null,
            'is_like'      =>$is_like,
            'area'      =>$this->area ? $this->area->name : null,
            'rate'      =>$this->rate,
            'facebook'      =>$this->store_info ? $this->store_info->facebook : null,
            'instagram'      =>$this->store_info ? $this->store_info->instagram : null,
            'twitter'      =>$this->store_info ? $this->store_info->twitter : null,
            'whatsapp'      =>$this->store_info ? $this->store_info->whatsapp : null,
            'snap'      =>$this->store_info ? $this->store_info->snap : null,
            'number_of_likes'      =>$this->likes->count(),
            'my_store'=> $this->id == Auth::user()->id ? true : false,
            'about_info'      =>$this->store_info ? $this->store_info->about_info : null,
            'cover_photo'      =>$this->store_info ? getImageUrl('Users',$this->store_info->cover_photo) : getImageUrl('Users',null) ,
            'our_services'      => ServicesResource::collection($this->services),
            'my_product'=>ProductResource::collection($this->my_product->take(4))
        ];
    }
}
