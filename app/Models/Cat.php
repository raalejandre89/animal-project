<?php

namespace App\Models;

class Cat extends Animal
{
    protected $table = 'animals';

    public static function getTypeValue()
    {
        return 'cat';
    }
}
