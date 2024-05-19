<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        /**
         * Run the migrations.
         */
        public function up(): void {

            Schema::table('estate_agents', function (Blueprint $table) {

                $table->dropColumn('email');
                $table->dropColumn('nome');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void {

            Schema::table('estate_agents', function (Blueprint $table) {

                $table->string('email')->unique()->after('celular');
                $table->string('nome')->after('email');
            });
        }
    };