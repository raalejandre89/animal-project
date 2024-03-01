<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cow extends Animal
{
    protected $table = 'animals';

    public static function getTypeValue()
    {
        return 'cow';
    }
}
