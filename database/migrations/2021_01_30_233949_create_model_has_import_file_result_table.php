<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateModelHasImportFileResultTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'model_has_import_file_result';
    public $table_comment = 'table pivot créant la liaison entre un modèle et un résultat d importation de fichier';

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

            $table->foreignId('import_file_result_id')->nullable()
                ->comment('référence du résultat d importation')
                ->constrained('import_file_results')->onDelete('set null');

            $table->string('model_type')->comment('type du modèle référencé');
            $table->bigInteger('model_id')->comment('référence du modèle');

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
            $table->dropForeign(['import_file_result_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
