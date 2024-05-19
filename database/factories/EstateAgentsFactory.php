<?php

namespace Database\Factories;

use App\Models\EstateAgents;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstateAgentsFactory extends Factory {

    use BrFaker;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EstateAgents::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {

        return [
            'celular' => $this->celular(),
            'email'   => $this->faker->unique()->safeEmail,
            'nome'    => $this->faker->name,
            'cpf'     => $this->cpf()
        ];
    }
}
