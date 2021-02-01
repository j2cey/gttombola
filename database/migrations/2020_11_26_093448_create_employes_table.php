<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;

class CreateEmployesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'employes';
    public $table_comment = 'liste des Employes';

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

            $table->string('nom')->comment('nom de l employe');
            $table->string('matricule')->nullable()->comment('matricule de l employe');
            $table->string('prenom')->nullable()->comment('prenom de l employe');
            $table->string('nom_complet')->nullable()->comment('nom complet de l employe');

            $table->string('objectguid')->nullable()->comment('UID');
            $table->string('adresse')->nullable()->comment('adresse de l employe');
            $table->binary('thumbnailphoto')->nullable()->comment('photo de profil de l employe');

            $table->foreignId('fonction_employe_id')->nullable()
                ->comment('reference de la fonction de l employe')
                ->constrained('fonction_employes')->onDelete('set null');

            $table->foreignId('departement_id')->nullable()
                ->comment('reference du departement d affectation de l employe (le cas echeant)')
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
            $table->dropForeign(['fonction_employe_id']);
            $table->dropForeign(['departement_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
