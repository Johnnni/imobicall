<?php

    namespace Database\Factories;

    use App\Models\EstateAgent;
    use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
     */
    class CustomerFactory extends Factory {

        use BrFaker;

        /**
         * Define the model's default state.
         *
         * @return array<string, mixed>
         */
        public function definition(): array {

            $estate_agents = EstateAgent::all();


            return [
                'celular' => $this->celular(),
                'email'   => $this->faker->unique()->safeEmail,
                'nome'    => $this->faker->name,
                'cpf'     => $this->cpf(),
                'estate_agent_id' => $estate_agents->random()->id
            ];
        }
    }
