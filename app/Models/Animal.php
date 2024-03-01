<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Animal extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'type_id',
        'age',
        'color',
        'favorite_food'
    ];

    protected static function booted()
    {
        static::addGlobalScope('typeScope', function (Builder $builder) {
            if (method_exists(static::class, 'getTypeValue')) {
                $builder->whereHas('type', function ($query) {
                    $query->where('name', static::getTypeValue());
                });
            }
        });

        static::creating(function ($model) {
            if (get_class($model) !== Animal::class) {
                $model->type_id = AnimalType::where('name', static::getTypeValue())->first()->id;
            }
        });
    }

    public function type()
    {
        return $this->belongsTo(AnimalType::class, 'type_id');
    }

    public function getSoundAttribute()
    {
        return $this->type()->first()->sound;
    }
}
