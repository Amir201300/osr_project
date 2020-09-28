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


    /**
     * @param $model_id
     * @param $type
     * @return mixed
     */
    public function likes($model_id , $type);

    /**
     * @param $model_id
     * @param $type
     * @param $comment
     * @return mixed
     */
    public function reporting($model_id , $type,$comment);

}