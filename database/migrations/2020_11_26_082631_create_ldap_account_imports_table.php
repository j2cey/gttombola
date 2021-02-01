<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateLdapAccountImportsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'ldap_account_imports';
    public $table_comment = 'derniere importation LDAP';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('objectguid')->nullable()->comment('GUID du compte');
            $table->string('username')->nullable()->comment('Account Name');
            $table->string('name')->nullable()->comment('nom complet du compte');

            $table->string('email')->nullable()->comment('e-mail du compte');
            $table->string('password')->nullable()->comment('mot de passe du compte');

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
