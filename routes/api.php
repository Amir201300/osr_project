<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use Illuminate\Http\Request;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');

header('Content-Type: application/json; charset=UTF-8', true);


/** Start Auth Route **/

Route::middleware('auth:api')->group(function () {
    //Auth_private
    Route::prefix('Auth_private')->group(function()
    {
        Route::post('/change_password', 'Api\UserController@change_password')->name('user.change_password');
        Route::post('/edit_profile', 'Api\UserController@edit_profile')->name('user.edit_profile');
        Route::get('/my_info', 'Api\UserController@my_info')->name('user.my_info');
        Route::get('/logout', 'Api\UserController@logout')->name('user.logout');
        Route::post('/view_user/{id}', 'Api\UserController@view_user')->name('user.view_user');
        Route::post('/change_password', 'Api\UserController@change_password')->name('user.change_password');
        Route::post('/save_image', 'Api\UserController@save_image')->name('user.save_image');
        Route::post('/check_code', 'Api\UserController@check_code')->name('user.check_code');
        Route::post('/resend_code', 'Api\UserController@resend_code')->name('user.resend_code');
    });

    //Categories routs
    Route::prefix('categories')->group(function()
    {
        Route::get('/main_categories', 'Api\CategoriesController@main_categories')->name('categories.main_categories');
        Route::get('/sup_categories/{parent_id}', 'Api\CategoriesController@sup_categories')->name('categories.sup_categories');
    });

    //jobs routs
    Route::prefix('jobs')->group(function()
    {
        Route::get('/get_jobs', 'Api\JobsController@get_jobs')->name('jobs.get_jobs');
        Route::get('/single_job/{id}', 'Api\JobsController@single_job')->name('jobs.single_job');
        Route::get('/jobs_by_city/{id}', 'Api\JobsController@jobs_by_city')->name('jobs.jobs_by_city');
        Route::get('/search_by_name', 'Api\JobsController@search_by_name')->name('jobs.search_by_name');
        Route::post('/add_job', 'Api\JobsController@add_job')->name('jobs.add_job');
    });

    //packages routs
    Route::prefix('packages')->group(function()
    {
        Route::get('/get_packages', 'Api\PackagesController@get_packages')->name('packages.get_packages');
        Route::get('/single_package/{id}', 'Api\PackagesController@single_package')->name('packages.single_package');
    });

    //Home routs
    Route::prefix('Home')->group(function()
    {
        Route::get('/home', 'Api\HomeController@home')->name('Home.home');
        Route::get('/product_by_cat/{cat_id}', 'Api\HomeController@product_by_cat')->name('Home.product_by_cat');
    });

    //Products routs
    Route::prefix('Products')->group(function()
    {
        Route::post('/add_product', 'Api\ProductsController@add_product')->name('Products.add_product');
        Route::post('/edit_product/{product_id}', 'Api\ProductsController@edit_product')->name('Products.edit_product');
        Route::post('/delete_product/{product_id}', 'Api\ProductsController@delete_product')->name('Products.delete_product');
        Route::post('/save_my_rate/{product_id}', 'Api\ProductsController@save_my_rate')->name('Products.save_my_rate');
        Route::post('/save_to_wishlist/{product_id}', 'Api\ProductsController@save_to_wishlist')->name('Products.save_to_wishlist');
        Route::get('/my_wishlist', 'Api\ProductsController@my_wishlist')->name('Products.my_wishlist');
        Route::get('/my_products', 'Api\ProductsController@my_products')->name('Products.my_products');
        Route::get('/get_product_rates/{product_id}', 'Api\ProductsController@get_product_rates')->name('Products.get_product_rates');
        Route::get('/single_product/{product_id}', 'Api\ProductsController@single_product')->name('Products.single_product');
        Route::get('/all_products', 'Api\ProductsController@all_products')->name('Products.all_products');
        Route::post('/likeOrUnlike/{product_id}', 'Api\ProductsController@likeOrUnlike')->name('Products.likeOrUnlike');
        Route::post('/reporting/{product_id}', 'Api\ProductsController@reporting')->name('Products.reporting');
    });

    //Courses info
    Route::prefix('Courses')->group(function()
    {
        Route::get('/get_Courses', 'Api\CoursesController@get_Courses')->name('Courses.get_Courses');
    });

//User_services info
    Route::prefix('User_services')->group(function()
    {
        Route::post('/add_service', 'Api\StoresController@add_service')->name('User_services.add_service');
        Route::post('/delete_service/{service_id}', 'Api\StoresController@delete_service')->name('User_services.delete_service');
    });

    //Stores info
    Route::prefix('Stores')->group(function()
    {
        Route::get('/get_stores', 'Api\StoresController@get_stores')->name('Stores.get_stores');
        Route::get('/search', 'Api\StoresController@search')->name('Stores.search');
        Route::get('/single_store/{id}', 'Api\StoresController@single_store')->name('Stores.single_store');
        Route::post('/update_info', 'Api\StoresController@update')->name('Stores.update_store');
        Route::post('/likeOrUnlike/{id}', 'Api\StoresController@likeOrUnlike')->name('Stores.likeOrUnlike');
        Route::post('/save_rate/{id}', 'Api\StoresController@save_rate')->name('Stores.save_rate');
        Route::get('/get_rates/{store_id}', 'Api\StoresController@get_rates')->name('Stores.get_rates');
        Route::post('/reporting/{store_id}', 'Api\StoresController@reporting')->name('Stores.reporting');
    });

});
/** End Auth Route **/

//general Auth
Route::prefix('Auth_general')->group(function()
{
    Route::post('/register', 'Api\UserController@register')->name('user.register');
    Route::post('/register_social', 'Api\UserController@register_social')->name('user.register_social');
    Route::post('/login', 'Api\UserController@login')->name('user.login');
    Route::get('/check_verify/{id}', 'Api\UserController@check_verify')->name('user.check_verify');
    Route::post('/forget_password', 'Api\UserController@forget_password')->name('user.forget_password');
    Route::post('/reset_password', 'Api\UserController@reset_password')->name('user.reset_password');
});


//General info
Route::prefix('general_info')->group(function()
{
    Route::get('/get_cities', 'Api\General_infoController@get_cities')->name('general_info.get_cities');
    Route::get('/get_area/{city_id}', 'Api\General_infoController@get_area')->name('general_info.get_area');
    Route::get('/get_Advices', 'Api\General_infoController@get_Advices')->name('general_info.get_Advices');
    Route::get('/FAQ', 'Api\General_infoController@FAQ')->name('general_info.FAQ');
    Route::get('/settings', 'Api\General_infoController@settings')->name('general_info.settings');
});


/** Settings  Route */
Route::prefix('Settings')->group(function()
{
    Route::post('/contact_us', 'Api\SettingsController@contact_us')->name('Settings.contact_us');
    Route::post('/complaint', 'Api\SettingsController@complaint')->name('Settings.complaint');
});



//Events routs
Route::prefix('Events')->group(function()
{
    Route::get('/get_Events', 'Api\EventController@get_Event')->name('Events.get_Event');
    Route::get('/single_Event/{id}', 'Api\EventController@single_Event')->name('Events.single_Event');
});

