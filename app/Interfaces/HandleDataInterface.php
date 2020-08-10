<?php

namespace App\Interfaces;

interface HandleDataInterface {
    /**
     * @param $data
     * @param $resource
     * @param $request
     * @return mixed
     */
    public function getAllData($data,$request,$resource);

    /**
     * @param $data
     * @param $request
     * @param $resorce
     * @return mixed
     */
    public function getSingleData($data,$request,$resorce);

    /**
     * @param $model
     * @param $model_id
     * @param $request
     * @return mixed
     */
    public function deleteData($model,$model_id,$request,$folderName=null);

}