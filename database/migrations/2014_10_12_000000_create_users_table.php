<?php

use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'users';
    public $table_comment = 'Liste de utilisateurs';

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

            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique()->comment('login du compte ou première partie de l adresse e-mail');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('image')->nullable()->comment('Avatar de l utilisateur');
            $table->boolean('is_local')->default(false)->comment('indique si le compte est locale');
            $table->boolean('is_ldap')->default(false)->comment('indique si le compte est LDAP');
            $table->string('objectguid')->nullable()->comment('GUID du compte');

            $table->string('login_type')->default("local")->comment('type de connexion');

            $table->rememberToken();
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
