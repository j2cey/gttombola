<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateParticipationsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'participations';
    public $table_comment = 'liste des participations a une tombola';

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

            $table->integer('valeur')->default(1)->comment('valeur de la participation');

            $table->foreignId('base_participation_id')->nullable()
                ->comment('reference de la base de participation')
                ->constrained('base_participations')->onDelete('set null');

            $table->foreignId('participant_id')->nullable()
                ->comment('reference du participant')
                ->constrained('participants')->onDelete('set null');
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
            $table->dropForeign(['base_participation_id']);
            $table->dropForeign(['participant_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
