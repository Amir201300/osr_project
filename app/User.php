<?php

namespace App;

use App\Models\Area;
use App\Models\City;
use App\Models\Product;
use App\Models\store_info;
use App\Models\User_services;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;


class User extends Authenticatable
{


    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo(Area::class,'area_id');
    }

    public  function whislist()
    {
        return $this->belongsToMany(Product::class,'wishlists','user_id','product_id')
            ->where('status',1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany(User_services::class,'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function store_info()
    {
        return $this->hasOne(store_info::class,'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function my_product()
    {
        return $this->hasMany(Product::class,'user_id');
    }

    /**
     * @param $type
     * @return bool
     */
    public function is_required_type($type)
    {
        $rasult=$this->user_type == $type ? true : false;
        return $rasult;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function rateRelation()
    {
        return $this->morphToMany('App\User','RateRelation','rates')->withPivot('rate','comment','created_at','updated_at','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(User::class,'likes','model_id','user_id')
            ->where('likes.type',1);
    }
}
