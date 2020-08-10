<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Resources\CityResource;


class PackagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'period'      => $this->period,
            'price'      => $this->price,
            'period_type'      => $this->period_type,
            'image'      => getImageUrl('Packages',$this->image) ,
            'desc'      => $this->desc,
        ];
    }
}
