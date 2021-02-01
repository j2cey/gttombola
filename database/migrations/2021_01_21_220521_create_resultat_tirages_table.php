<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateResultatTiragesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'resultat_tirages';
    public $table_comment = 'resultats d un tirage effectue pour une tombola';

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

            $table->foreignId('tirage_id')->nullable()
                ->comment('reference du tirage')
                ->constrained('tirages')->onDelete('set null');

            $table->foreignId('participant_id')->nullable()
                ->comment('reference du participant')
                ->constrained('participants')->onDelete('set null');

            $table->boolean('retenu')->default(false)->comment('indique si ce resultat est retenu');
            $table->string('commentaire')->nullable()->comment('description du tirage');
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
            $table->dropForeign(['tirage_id']);
            $table->dropForeign(['participant_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
