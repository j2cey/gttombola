<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateTombolasTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'tombolas';
    public $table_comment = 'liste des tombola';

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

            $table->string('titre')->nullable()->comment('titre de la tombola');
            $table->string('description')->nullable()->comment('description de la tombola');
            $table->string('fichier_reglement')->nullable()->comment('fichier de reglement de la tombola.');
            $table->string('fichier_reglement_type')->nullable()->comment('fichier de reglement de la tombola.');
            $table->integer('fichier_reglement_size')->nullable()->comment('fichier de reglement de la tombola.');
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
