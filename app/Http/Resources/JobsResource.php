<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Resources\CityResource;


class JobsResource extends JsonResource
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
            'job_type'      => $this->job_type,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'salary'      => $this->salary,
            'city'      => $this->city->name ,
            'city_id'      => (int)$this->city_id ,
           // 'user_id'      => $this->user_id ? $this->user_id->name : null,
            'desc'      => $this->desc,
        ];
    }
}
