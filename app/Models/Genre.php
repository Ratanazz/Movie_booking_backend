<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use CrudTrait;
    public function movies()
    {
        return $this->hasMany(Movie::class);
    }
}
