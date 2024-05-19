<?php

    namespace Database\Seeders;

    use App\Models\Customer;
    use App\Models\EstateAgent;
    use Illuminate\Database\Seeder;

    class CustomerTableSeeder extends Seeder {
        /**
         * Run the database seeds.
         */
        public function run(): void {

            Customer::factory(200)->create();

        }
    }
