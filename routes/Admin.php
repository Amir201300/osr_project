<?php

Route::post('/admin/login','Manage\MainController@login')->name('admin.login');


Route::group(['prefix' => LaravelLocalization::setLocale(),

    'middleware' => ['localeSessionRedirect','localizationRedirect','localeViewPath']] ,  function()

{
    Route::prefix('manage')->group(function()
    {
        Route::get('/login' , function(){
            return view('manage.loginAdmin');
        });
        Route::group(['middleware' => 'roles' , 'roles' => ['SuperAdmin','Admin','rant','daleel','house']], function ()
        {



            Route::get('/logout/logout','Manage\MainController@logout')->name('user.logout');
            Route::get('/home', 'Manage\MainController@index')->name('admin.dashboard');

            // Profile Route
            Route::prefix('profile')->group(function()
            {
                Route::get('/index', 'Manage\profileController@index')->name('profile.index');
                Route::post('/index', 'Manage\profileController@update')->name('profile.update');
            });
            //City routes
            Route::prefix('City')->group(function () {
                Route::get('/index', 'Manage\CityController@index')->name('City.index');
                Route::get('/view', 'Manage\CityController@view')->name('City.view');
                Route::post('/store', 'Manage\CityController@store')->name('City.store');
                Route::get('/show/{id}', 'Manage\CityController@show')->name('City.show');
                Route::post('/update', 'Manage\CityController@update')->name('City.update');
                Route::get('/delete/{id}', 'Manage\CityController@delete')->name('City.delete');
            });

            //Slider routes
            Route::prefix('Slider')->group(function () {
                Route::get('/index', 'Manage\SliderController@index')->name('Slider.index');
                Route::get('/view', 'Manage\SliderController@view')->name('Slider.view');
                Route::post('/store', 'Manage\SliderController@store')->name('Slider.store');
                Route::get('/show/{id}', 'Manage\SliderController@show')->name('Slider.show');
                Route::post('/update', 'Manage\SliderController@update')->name('Slider.update');
                Route::get('/delete/{id}', 'Manage\SliderController@delete')->name('Slider.delete');
            });

            //Jobs routes
            Route::prefix('Jobs')->group(function () {
                Route::get('/index', 'Manage\JobsController@index')->name('Jobs.index');
                Route::get('/view', 'Manage\JobsController@view')->name('Jobs.view');
                Route::post('/store', 'Manage\JobsController@store')->name('Jobs.store');
                Route::get('/show/{id}', 'Manage\JobsController@show')->name('Jobs.show');
                Route::post('/update', 'Manage\JobsController@update')->name('Jobs.update');
                Route::get('/delete/{id}', 'Manage\JobsController@delete')->name('Jobs.delete');
            });

            //Packages routes
            Route::prefix('Packages')->group(function () {
                Route::get('/index', 'Manage\PackagesController@index')->name('Packages.index');
                Route::get('/view', 'Manage\PackagesController@view')->name('Packages.view');
                Route::post('/store', 'Manage\PackagesController@store')->name('Packages.store');
                Route::get('/show/{id}', 'Manage\PackagesController@show')->name('Packages.show');
                Route::post('/update', 'Manage\PackagesController@update')->name('Packages.update');
                Route::get('/delete/{id}', 'Manage\PackagesController@delete')->name('Packages.delete');
            });

            //Area routes
            Route::prefix('Area')->group(function () {
                Route::get('/index', 'Manage\AreaController@index')->name('Area.index');
                Route::get('/view', 'Manage\AreaController@view')->name('Area.view');
                Route::post('/store', 'Manage\AreaController@store')->name('Area.store');
                Route::get('/show/{id}', 'Manage\AreaController@show')->name('Area.show');
                Route::post('/update', 'Manage\AreaController@update')->name('Area.update');
                Route::get('/delete/{id}', 'Manage\AreaController@delete')->name('Area.delete');
            });

            //Advices routes
            Route::prefix('Advices')->group(function () {
                Route::get('/index', 'Manage\AdvicesController@index')->name('Advices.index');
                Route::get('/view', 'Manage\AdvicesController@view')->name('Advices.view');
                Route::post('/store', 'Manage\AdvicesController@store')->name('Advices.store');
                Route::get('/show/{id}', 'Manage\AdvicesController@show')->name('Advices.show');
                Route::post('/update', 'Manage\AdvicesController@update')->name('Advices.update');
                Route::get('/delete/{id}', 'Manage\AdvicesController@delete')->name('Advices.delete');
            });




            Route::prefix('categories')->group(function () {
                Route::get('/index', 'Manage\CategoriesController@index')->name('categories.index');
                Route::get('/view', 'Manage\CategoriesController@view')->name('categories.view');
                Route::post('/store', 'Manage\CategoriesController@store')->name('categories.store');
                Route::get('/show/{id}', 'Manage\CategoriesController@show')->name('categories.show');
                Route::post('/update', 'Manage\CategoriesController@update')->name('categories.update');
                Route::get('/delete/{id}', 'Manage\CategoriesController@delete')->name('categories.delete');
            });

            /** Product Routes */
            Route::prefix('Product')->group(function () {
                Route::get('/index', 'Manage\ProductController@index')->name('Product.index');
                Route::get('/view', 'Manage\ProductController@view')->name('Product.view');
                Route::post('/store', 'Manage\ProductController@store')->name('Product.store');
                Route::get('/show/{id}', 'Manage\ProductController@show')->name('Product.show');
                Route::get('/ChangeStatus/{id}', 'Manage\ProductController@ChangeStatus')->name('Product.ChangeStatus');
                Route::post('/update', 'Manage\ProductController@update')->name('Product.update');
                Route::get('/delete/{id}', 'Manage\ProductController@delete')->name('Product.delete');
            });

            /** User Routes */
            Route::prefix('User')->group(function () {
                Route::get('/index', 'Manage\UserController@index')->name('User.index');
                Route::get('/view', 'Manage\UserController@view')->name('User.view');
                Route::post('/store', 'Manage\UserController@store')->name('User.store');
                Route::get('/show/{id}', 'Manage\UserController@show')->name('User.show');
                Route::get('/ChangeStatus/{id}', 'Manage\UserController@ChangeStatus')->name('User.ChangeStatus');
                Route::post('/update', 'Manage\UserController@update')->name('User.update');
                Route::get('/delete/{id}', 'Manage\UserController@delete')->name('User.delete');
            });

            /** Rate Routes */
            Route::prefix('Rate')->group(function () {
                Route::get('/show/{id}', 'Manage\RateController@show')->name('Rate.show');
                Route::get('/get_rates/{id}', 'Manage\RateController@get_rates')->name('Rate.get_rates');
                Route::get('/ProductRate/{id}', 'Manage\RateController@ProductRate')->name('Rate.ProductRate');
                Route::get('/delete/{id}', 'Manage\RateController@delete')->name('Rate.delete');
            });

            /** Courses Routes */
            Route::prefix('Courses')->group(function () {
                Route::get('/index', 'Manage\CoursesController@index')->name('Courses.index');
                Route::get('/view', 'Manage\CoursesController@view')->name('Courses.view');
                Route::post('/store', 'Manage\CoursesController@store')->name('Courses.store');
                Route::get('/show/{id}', 'Manage\CoursesController@show')->name('Courses.show');
                Route::post('/update', 'Manage\CoursesController@update')->name('Courses.update');
                Route::get('/delete/{id}', 'Manage\CoursesController@delete')->name('Courses.delete');
            });

        });
    });
});

