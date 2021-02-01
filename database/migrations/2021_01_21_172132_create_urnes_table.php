<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateUrnesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'urnes';
    public $table_comment = 'liste des urnes d une tombola';

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

            $table->string('table_participation')->comment('table de participation (contenant la liste des participants) de l urne');
            $table->string('titre')->comment('titre de l urne');
            $table->string('prefix_selection_numero')->nullable()->comment('valeur de selection de numero');
            $table->string('description')->nullable()->comment('description de l urne');

            $table->foreignId('tombola_id')->nullable()
                ->comment('reference de la tombola')
                ->constrained('tombolas')->onDelete('set null');

            $table->foreignId('type_urne_id')->nullable()
                ->comment('reference du type d urne')
                ->constrained('type_urnes')->onDelete('set null');
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
            $table->dropForeign(['type_urne_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
