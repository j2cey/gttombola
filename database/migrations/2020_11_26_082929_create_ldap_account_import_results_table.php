<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;

class CreateLdapAccountImportResultsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'ldap_account_import_results';
    public $table_comment = 'résultats importation LDAP';

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

            $table->integer('lines_count')->nullable()->comment('nombre de ligne importées');
            $table->integer('lines_parsed')->default(0)->comment('nombre de lignes parsées');
            $table->integer('lines_parse_success')->nullable()->comment('nombre de lignes parsées avec succès');
            $table->integer('lines_parse_fail')->nullable()->comment('nombre de lignes dont le parse a échouée');

            $table->json('report')->comment('rapport de traitement');
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
