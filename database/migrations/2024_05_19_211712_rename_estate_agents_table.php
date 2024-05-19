<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        /**
         * Run the migrations.
         */
        public function up() {

            Schema::rename('estate_agents', 'estate_agent');
        }

        /**
         * Reverse the migrations.
         */
        public function down() {

            Schema::rename('estate_agent', 'estate_agents');
        }
    };
