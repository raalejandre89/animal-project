<?php

namespace App\Console\Commands;

use App\Models\Animal;
use App\Models\AnimalType;
use App\Models\Cat;
use App\Models\Dog;
use App\Models\Cow;
use Illuminate\Console\Command;

/**
 * Command handler that creates an API user.
 * Class CreateAnimal
 * @package App\Console\Commands
 */
class CreateAnimal extends Command
{
    protected static $implementedTypes = ['cat', 'dog', 'cow'];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create
                            {names : The names of the animals.}
                            {types : The types of animals.}
                            {--ages= : The ages of animals.}
                            {--colors= : The colors of animals.}
                            {--foods= : The favorite food of animals.}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates one or multiple Animals.';

    protected $names = [];
    protected $types = [];
    protected $ages = [];
    protected $colors = [];
    protected $foods = [];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->names = explode(',', $this->argument('names'));
        $this->types = explode(',', $this->argument('types'));
        $this->ages = explode(',', $this->option('ages'));
        $this->colors = explode(',', $this->option('colors'));
        $this->foods = explode(',', $this->option('foods'));

        if (count($this->names) != count($this->types)) {
            $this->error('The number of animals doen\'t match the number of types of animals');
            return 1;
        }

        $this->validateTypes();

        for ($i = 0; $i < count($this->names) ;$i++) {
            if (in_array(strtolower($this->types[$i]), self::$implementedTypes)) {
                $modelName = "App\\Models\\" . ucfirst(strtolower($this->types[$i]));
                $animal = new $modelName();
            } else if (strtolower($this->types[$i]) == 'unicorn') {
                $this->info("Unicorns are not real!");
                continue;
            } else {
                $animal = new Animal();
                $animal->type_id = AnimalType::where('name', $this->types[$i])->first()->id;
            }

            $animal->name = $this->names[$i];
            $animal->age = (array_key_exists($i, $this->ages) && ($this->ages[$i] !== '') ? $this->ages[$i] : 0);
            $animal->color = array_key_exists($i, $this->colors) ? $this->colors[$i] : '';
            $animal->food = array_key_exists($i, $this->foods) ? $this->foods[$i] : '';
            $animal->save();

            $this->info("{$animal->name} says \"{$animal->sound}\"!");
        }
    }

    private function validateTypes()
    {
        $result = true;

        for ($i = 0; $i < count($this->types); $i++) {
            if (! AnimalType::where('name', strtolower($this->types[$i]))->exists() && strtolower($this->types[$i]) != 'unicorn') {
                if ($this->confirm("The type {$this->types[$i]} doesn't exists. Do you want to create it?")) {
                    $result = $this->createNewType($this->types[$i]);
                } else {
                    $result = false;
                }

                if (!$result) {
                    $this->warn('The sound of the animal is unknown. Skipping this animal.');
                    unset($this->types[$i]);
                    unset($this->names[$i]);
                    unset($this->ages[$i]);
                    unset($this->colors[$i]);
                    unset($this->foods[$i]);
                }
            }
        }

        return $result;
    }

    private function createNewType($type)
    {
        $sound = $this->ask("Great! What does the {$type} says?");

        if (empty($sound)) {
            $this->warn('No sound provided.');

            return false;
        }

        AnimalType::create(['name' => $type, 'sound' => $sound]);

        return true;
    }
}
