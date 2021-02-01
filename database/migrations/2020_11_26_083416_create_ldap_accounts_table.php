<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateLdapAccountsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'ldap_accounts';
    public $table_comment = 'Comptes LDAP';

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

            $table->string('objectguid')->nullable()->comment('GUID du compte');
            $table->string('username')->unique()->comment('login du compte');
            $table->string('email')->nullable()->comment('e-mail du compte');
            $table->string('password')->nullable()->comment('mot de passe du compte');

            $table->string('cn')->nullable()->comment('nom complet');
            $table->string('cn_result')->nullable()->comment('résultat cn de la derniere importation');

            $table->string('sn')->nullable()->comment('nom de famille');
            $table->string('sn_result')->nullable()->comment('résultat sn de la derniere importation');

            $table->string('title')->nullable()->comment('titre de l employe');
            $table->string('title_result')->nullable()->comment('résultat title de la derniere importation');

            $table->string('description')->nullable()->comment('fonction de l employe');
            $table->string('description_result')->nullable()->comment('résultat description de la derniere importation');

            $table->string('physicaldeliveryofficename')->nullable()->comment('unité d affectation');
            $table->string('physicaldeliveryofficename_result')->nullable()->comment('résultat physicaldeliveryofficename de la derniere importation');

            $table->string('telephonenumber')->nullable()->comment('numero de telephone de l employé');
            $table->string('telephonenumber_result')->nullable()->comment('résultat telephonenumber de la derniere importation');

            $table->string('givenname')->nullable()->comment('prénom de l employé');
            $table->string('givenname_result')->nullable()->comment('résultat givenname de la derniere importation');

            $table->string('distinguishedname')->nullable()->comment('infos complets de l employé');
            $table->string('distinguishedname_result')->nullable()->comment('résultat distinguishedname de la derniere importation');

            $table->string('service')->nullable()->comment('service deduit apres traitement');
            $table->string('division')->nullable()->comment('division deduite apres traitement');
            $table->string('direction')->nullable()->comment('direction deduite apres traitement');
            $table->string('agence')->nullable()->comment('agence deduite apres traitement');
            $table->string('zone')->nullable()->comment('zone deduite apres traitement');

            $table->string('whencreated')->nullable()->comment('date creation');
            $table->string('whencreated_result')->nullable()->comment('résultat whencreated de la derniere importation');

            $table->string('whenchanged')->nullable()->comment('date dernière modif');
            $table->string('whenchanged_result')->nullable()->comment('résultat whenchanged de la derniere importation');

            $table->string('department')->nullable()->comment('département de l employe');
            $table->string('department_result')->nullable()->comment('résultat department de la derniere importation');

            $table->string('company')->nullable()->comment('entreprise de l employe');
            $table->string('company_result')->nullable()->comment('résultat company de la derniere importation');

            $table->string('name')->nullable()->comment('nom de famille');
            $table->string('name_result')->nullable()->comment('résultat name de la derniere importation');

            $table->string('badpwdcount')->nullable()->comment('nombre de mot de passe érroné');
            $table->string('badpwdcount_result')->nullable()->comment('résultat badpwdcount de la derniere importation');

            $table->string('logoncount')->nullable()->comment('nombre d authentification');
            $table->string('logoncount_result')->nullable()->comment('résultat logoncount de la derniere importation');

            $table->string('samaccountname')->nullable()->comment('login ldap');
            $table->string('samaccountname_result')->nullable()->comment('résultat samaccountname de la derniere importation');

            $table->string('userprincipalname')->nullable()->comment('userprincipalname');
            $table->string('userprincipalname_result')->nullable()->comment('résultat userprincipalname de la derniere importation');

            $table->string('mail')->nullable()->comment('adresse mail');
            $table->string('mail_result')->nullable()->comment('résultat mail de la derniere importation');

            $table->binary('thumbnailphoto')->nullable()->comment('photo de profil');
            $table->string('thumbnailphoto_result')->nullable()->comment('résultat thumbnailphoto de la derniere importation');
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
