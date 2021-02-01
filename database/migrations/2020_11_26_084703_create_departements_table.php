<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateDepartementsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'departements';
    public $table_comment = 'liste des départements';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->baseFields();

            $table->string('intitule')->comment('intitule du departement');
            $table->string('chemin_complet')->nullable()->comment('chemin complet du departement en tenant compte des parents');
            $table->string('description')->nullable()->comment('description du departement');

            $table->foreignId('type_departement_id')->nullable()
                ->comment('reference du type de departement')
                ->constrained('type_departements')->onDelete('set null');

            $table->foreignId('departement_parent_id')->nullable()
                ->comment('reference du departement parent')
                ->constrained('departements')->onDelete('set null');
        });
        $this->setTableComment($this->table_name,$this->table_comment);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropBaseForeigns();
            $table->dropForeign(['type_departement_id']);
            $table->dropForeign(['departement_parent_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
