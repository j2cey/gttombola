<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateBaseParticipationsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'base_participations';
    public $table_comment = 'base contenant les participations a une tombola';

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

            $table->foreignId('tombola_id')->nullable()
                ->comment('reference de la tombola')
                ->constrained('tombolas')->onDelete('set null');

            $table->string('fichier')->nullable()->comment('nom du fichier de la base');
            $table->string('fichier_type')->nullable()->comment('type du fichier.');
            $table->integer('fichier_size')->nullable()->comment('taille du fichier.');

            $table->string('separateur_colonnes')->default(";")->comment('séparateur de colonnes');
            $table->boolean('entete_premiere_ligne')->default(false)->comment('détermine si le fichier comporte une en-tete de colonnes');
            $table->boolean('vider_urnes')->default(false)->comment('détermine si les urnes de la tombola doivent etre vidées avant chargement');
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
