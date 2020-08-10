<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       $date= \Carbon\Carbon::setLocale('ar');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image'=>getImageUrl('Users',$this->image),
            'rate' => (int)$this->pivot->rate,
            'comment'=>$this->pivot->comment,
            'created_at'=>$this->pivot->created_at->diffForHumans()
        ];
    }
}
