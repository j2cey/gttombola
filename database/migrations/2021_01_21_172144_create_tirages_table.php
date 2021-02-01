<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateTiragesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'tirages';
    public $table_comment = 'tirages effectues pour une tombola';

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

            $table->string('titre')->comment('titre du tirage');
            $table->integer('nombre_a_tirer')->comment('nombre de numéros à tirer');
            $table->string('description')->nullable()->comment('description du tirage');

            $table->timestamp('tirage_start_at')->nullable()->comment('date de debut du tirage');
            $table->timestamp('tirage_end_at')->nullable()->comment('date de fin du tirage');
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
