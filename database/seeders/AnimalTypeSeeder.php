<?php

namespace Database\Seeders;

use App\Models\AnimalType;
use App\Models\Client;
use App\Models\PaymentMethodType;
use Illuminate\Database\Seeder;

class AnimalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $animalTypes = [
            ['name' => 'cat', 'sound' => 'meow'],
            ['name' => 'dog', 'sound' => 'woof'],
            ['name' => 'cow', 'sound' => 'moo'],
        ];

        /**
         * Create the Animal Types
         */
        AnimalType::insert($animalTypes);
    }
}
