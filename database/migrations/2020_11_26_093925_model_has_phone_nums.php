<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class ModelHasPhoneNums extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'model_has_phone_nums';
    public $table_comment = 'table de liaison entre un modèle et un numéro de phone.';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            //$table->baseFields();

            $table->foreignId('phone_num_id')->nullable()
                ->comment('référence du numéro de phone')
                ->constrained('phone_nums')->onDelete('set null');

            $table->string('model_type')->comment('type du modèle référencé');
            $table->bigInteger('model_id')->comment('référence du modèle');

            $table->integer('posi')->default(0)->comment('position du numéro de phone dans la liste de numéros.');
            //$table->index(['employe_id','rang']);
            $table->timestamps();
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
            //$table->dropBaseForeigns();
            $table->dropForeign(['phone_num_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
