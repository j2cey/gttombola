<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateFonctionEmployesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'fonction_employes';
    public $table_comment = 'liste des fonctions d un employe';

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

            $table->string('intitule')->comment('intitule de la fonction');
            $table->string('slug')->unique()->comment('slug de l intitule de la fonction');
            $table->string('description')->nullable()->comment('description de la fonction');
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
        });
        Schema::dropIfExists($this->table_name);
    }
}
