<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateParametreParticipationsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'parametre_participations';
    public $table_comment = 'paramètres appliqués a la base de participations d une tombola';

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

            $table->string('separateur_colonnes')->default(";")->comment('séparateur de colonnes dans le fichier base de participation.');
            $table->integer('position_numero')->default(1)->comment('position du numéro dans la base de participation.');
            $table->integer('position_valeur')->default(2)->comment('position de la valeur dans la base de participation. -1 pour ne prendre en compte que la valeur 1');
            $table->boolean('participation_unique')->default(true)->comment('détermine si un numéro peut etre multiplié dans l urne.');
            $table->string('participation_unite')->nullable()->comment('unité de participation (participation multiple)');
            $table->integer('participation_valeurunitaire')->default(1)->comment('valeur unitaire de participation (participation multiple)');

            $table->foreignId('tombola_id')->nullable()
                ->comment('reference de la tombola')
                ->constrained('tombolas')->onDelete('set null');
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
            $table->dropForeign(['tombola_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
