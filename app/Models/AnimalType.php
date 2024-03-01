<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalType extends Model
{
    protected $table = 'animal_types';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'sound'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function animals()
    {
        return $this->hasMany(Animal::class, 'type_id');
    }
}
