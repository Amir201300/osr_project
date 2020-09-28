<?php
/**
 * @return string
 */

function get_url()
{
    return 'http://minelbayt.com';
}

/**
 * @param string $folder
 * @param $image
 * @return string
 */
function getImageUrl(string $folder, $image)
{
    if ($image)
        return get_url() . '/images/' . $folder . '/' . $image;
    return get_url() . '/images/1.png';
}

/**
 * @param $folder
 * @param $file
 * @return string
 */
function saveImage($folder, $file)
{
    $image = $file;
    $input['image'] = mt_rand() . time() . '.' . $image->getClientOriginalExtension();
    $dist = public_path('/images/' . $folder . '/');
    $image->move($dist, $input['image']);
    return $input['image'];
}

/**
 * @param $folder
 * @param $file
 * @return int
 */
function deleteFile($folder,$file)
{
    $file = public_path('/images/'.$folder.'/'.$file);
    if(file_exists($file))
    {
        File::delete($file);
    }
    return 1;
}



/**
 * @param $type
 * @return mixed
 */
function getCount($type)
{
    if($type == 1)
        $count=\App\User::where('user_type',1)->count();
    if($type == 2)
        $count=\App\User::where('user_type',2)->count();
    if($type == 3)
        $count=\App\User::where('user_type',3)->count();
    if($type == 4)
        $count=\App\Models\Product::count();
    return $count;
}

/**
 * @param $type
 * @param $count
 * @return mixed
 */
function get_user($type,$count)
{
    $users = \App\User::where('user_type',$type)->take($count)->orderBy('created_at','desc')->get();
    return $users;
}

/**
 * @param $type
 * @param $count
 * @return mixed
 */
function getProducts($type,$count)
{
    if($type == 1)
        $products=\App\Models\Product::orderBy('view','desc')->take($count)->get();
    if($type == 2)
        $products=\App\Models\Product::orderBy('created_at','desc')->take($count)->get();

    return $products;
}

/**
 * @param $product
 * @return null
 */
function productImage($product)
{
    $image=$product->Product_images->count() > 0 ? $product->Product_images[0]->image : null;
    return $image;
}


function getRate($type)
{
    if($type == 1)
        $rate=\App\Models\Rate::where('rate','>',3)->count();
    if($type == 2)
        $rate=\App\Models\Rate::where('rate','<',2)->count();
    if($type == 3)
        $rate=\App\Models\Rate::where('rate','>',2)->where('rate','<',4)->count();
    if($type == 4)
        $rate=\App\Models\Rate::count();
    if($type == 5)
        $rate=\App\Models\Rate::whereMonth('created_at',now())->count();

    $percntage=$rate * 100 / \App\Models\Rate::count();
    return [$rate,$percntage];
}

function lastUserRate()
{
    $usersIds=\App\Models\Rate::whereMonth('created_at',now())->pluck('user_id')->toArray();
    $users=\App\User::whereIn('id',$usersIds)->take(5)->get();
    return $users;

}