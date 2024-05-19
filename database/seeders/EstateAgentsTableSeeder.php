<?php

    namespace Database\Seeders;

    use App\Models\EstateAgent;
    use Illuminate\Database\Seeder;


    class EstateAgentsTableSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run() {

            EstateAgent::factory()->count(50)->create();
        }
    }
