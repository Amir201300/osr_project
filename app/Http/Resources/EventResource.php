<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Resources\CityResource;


class EventResource extends JsonResource
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
            'id'        => $this->id,
            'name'      => $this->name,
            'date'      => $this->date,
            'lat'      => $this->lat,
            'phone'      => $this->phone,
            'lng'      => $this->lng,
            'address'      => $this->address ,
            'desc'      => $this->desc,
            'link'      => $this->link,
            'image'      => getImageUrl('Event',$this->image),
            'created_at'=>$this->created_at->diffForHumans()
        ];
    }
}
