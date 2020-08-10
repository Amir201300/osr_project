<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product_imagesResource extends JsonResource

{

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'image'   =>getImageUrl('Product_images',$this->image),
            'product_id' =>(int) $this->product_id,
        ];

    }
}
