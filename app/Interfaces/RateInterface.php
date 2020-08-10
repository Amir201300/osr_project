<?php

namespace App\Interfaces;

interface RateInterface {
    /**
     * @param string $type
     * @param $request
     * @param $model
     * @param int $model_id
     * @return mixed
     */
    public function rating(string $type,$request,$model,int $model_id);

}