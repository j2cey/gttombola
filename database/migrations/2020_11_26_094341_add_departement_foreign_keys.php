<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartementForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departements', function (Blueprint $table) {
            $table->foreignId('employe_responsable_id')->nullable()
                ->comment('reference de l employe responsable du departement')
                ->constrained('employes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departements', function (Blueprint $table) {
            $table->dropForeign(['employe_responsable_id']);
        });
    }
}
