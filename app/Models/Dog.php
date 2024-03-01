<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dog extends Animal
{
    protected $table = 'animals';

    public static function getTypeValue()
    {
        return 'dog';
    }
}
