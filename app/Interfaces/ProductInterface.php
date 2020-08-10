<?php


namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductInterface
{
    /**
     * @param $request
     * @param $id
     * @param $admin
     * @return mixed
     */
    public function save_or_update($request,$id,$admin);

    /**
     * @param $request
     * @param $id
     * @param $admin
     * @return mixed
     */
    public function validate_product($request,$id,$admin);

    /**
     * @param $image
     * @param $id
     * @return mixed
     */
    public function upload_product_image($image,$id);

    /**
     * @param $id
     * @return mixed
     */
    public function delete_product_image($id);

    /**
     * @param $product_id
     * @param $admin
     * @return mixed
     */
    public function delete_product($product_id,$admin);

    /**
     * @param $product_id
     * @return mixed
     */
    public function save_to_wishlist($product_id);

}