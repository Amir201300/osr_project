<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Manage\BaseController;


class UserResource extends JsonResource
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
            'phone'     => $this->phone,
            'email'     => $this->email,
            'status'    => (int)$this->status,
            'user_type' => (int)$this->user_type,
            'social'    => (int)$this->social,
            'image'     => getImageUrl('Users',$this->image),
            'token'     => $this->token,
            'city'      =>$this->city ? $this->city->name : null,
            'area'      =>$this->area ? $this->area->name : null,
        ];
    }
}
