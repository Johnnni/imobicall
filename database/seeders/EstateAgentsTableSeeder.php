<?php

    namespace Database\Seeders;

    use App\Models\EstateAgents;
    use Illuminate\Database\Seeder;


    class EstateAgentsTableSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run() {

            EstateAgents::factory()->count(50)->create();
        }
    }
