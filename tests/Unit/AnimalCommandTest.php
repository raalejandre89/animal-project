<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimalCommandTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function create_one_defined_animal()
    {
        $this->artisan('create', ['names' => 'Rolo', 'types' => 'dog'])
            ->expectsOutput('Rolo says "woof"!')
            ->assertExitCode(0);
    }

    /** @test */
    public function create_one_undefined_animal()
    {
        $this->artisan('create', ['names' => 'Lulo', 'types' => 'frog'])
            ->expectsQuestion('The type frog doesn\'t exists. Do you want to create it?', 'Yes')
            ->expectsQuestion('Great! What does the frog says?', 'ribbit')
            ->expectsOutput('Lulo says "ribbit"!')
            ->assertExitCode(0);
    }

    /** @test */
    public function create_one_undefined_animal_fail()
    {
        $this->artisan('create', ['names' => 'Lulo', 'types' => 'fox'])
             ->expectsQuestion('The type fox doesn\'t exists. Do you want to create it?', 'Yes')
             ->expectsQuestion('Great! What does the fox says?', '')
             ->expectsOutput('No sound provided.')
             ->assertExitCode(0);
    }

    /** @test */
    public function create_multiple_animals_fail()
    {
        $this->artisan('create', ['names' => 'Blake,Riki', 'types' => 'dog'])
            ->expectsOutput('The number of animals doen\'t match the number of types of animals')
            ->assertExitCode(1);
    }

    /** @test */
    /** @test */
    public function create_multiple_animals()
    {
        $this->artisan('create', ['names' => 'Blake,Riki', 'types' => 'dog,cat'])
             ->expectsOutput('Blake says "woof"!')
             ->expectsOutput('Riki says "meow"!')
             ->assertExitCode(0);
    }
}
