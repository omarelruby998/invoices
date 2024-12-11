<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class products extends Model
{

    use HasTranslations;

    public $translatable = ['name'];

    public function user_wishlists()
    {
        return $this->hasMany();
    }

}
