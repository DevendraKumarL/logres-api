<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'people';

    public $fillable = ['firstname', 'lastname', 'age', 'description'];
}
