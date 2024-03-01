<?php

namespace App\Console\Commands;

use App\Models\Animal;
use App\Models\AnimalType;
use App\Models\User;
use App\Models\Cat;
use App\Models\Dog;
use App\Models\Cow;
use Illuminate\Console\Command;


/**
 * Command handler that creates an API user.
 * Class ListAnimals
 * @package App\Console\Commands
 */
class ListAnimals extends Command
{
    protected static $implementedTypes = ['cat', 'dog', 'cow'];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'animal:list';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List Animals.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $columns = ['Name', 'Type', 'Age', 'Color', 'Food'];
        $types = AnimalType::all()->pluck('name')->all();
        $types[] = 'all';
        $type = $this->choice(
            'What type of animal do you want to list',
            $types,
            count($types)-1,
            3,
            false
        );

        if (!in_array(strtolower($type),$types)) {
            $this->error("Invalid type provided.");
            return 1;
        }

        if (strtolower($type) === 'all') {
            $animalModel = Animal::class;
        } else {
            $modelName = "App\\Models\\" . ucfirst(strtolower($type));
            $animalModel = class_exists($modelName) ? new $modelName() : '';
        }

        if (isset($modelName) && !class_exists($modelName)) {
            $animals = Animal::withoutGlobalScopes()->whereHas('type', function ($query) use($type){
                                                        $query->where('name',strtolower($type));
                                                    })
                                                    ->get()
                                                    ->map(function ($animal) {
                                                        return [
                                                            $animal->name,
                                                            $animal->type->name,
                                                            $animal->age,
                                                            $animal->color,
                                                            $animal->food
                                                        ];
            })->toArray();
        } else {
            $animals = $animalModel::with('type')->get()->map(function ($animal) {
                return [$animal->name, $animal->type->name, $animal->age, $animal->color, $animal->food];
            })->toArray();
        }

        $this->table(
            $columns,
            $animals
        );
    }
}
