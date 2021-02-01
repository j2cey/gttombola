<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateImportFileResultsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'import_file_results';
    public $table_comment = 'resultats d importation de fichiers';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique()->comment('identifiant universel unique');

            $table->timestamp('importstart_at')->nullable()->comment('date de debut d importation dans la BD');
            $table->timestamp('importend_at')->nullable()->comment('date de fin d importation dans la BD');

            $table->integer('nb_to_import')->default(0)->comment('nombre total de lignes');
            $table->integer('nb_import_processing')->default(0)->comment('nombre d\'importation(s) en cours');
            $table->integer('nb_import_success')->default(0)->comment('nombre total de lignes importees avec succès');
            $table->integer('nb_import_failed')->default(0)->comment('nombre total de lignes echouees');
            $table->integer('nb_import_processed')->default(0)->comment('nombre d\'importation(s) effectuée(s)');
            $table->integer('import_rate')->default(0)->comment('pourcentage d\'importation(s) effectuée(s)');

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
        Schema::dropIfExists($this->table_name);
    }
}
