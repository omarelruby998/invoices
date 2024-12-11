<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class WishList extends Model
{


    protected $table='wishlist';
    public $fillable = ['user_id','product_id'];



}
