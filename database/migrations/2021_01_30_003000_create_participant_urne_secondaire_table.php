<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateParticipantUrneSecondaireTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'participant_urne_secondaire';
    public $table_comment = 'occurence d un participant dans une urne secondaire';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->foreignId('urne_secondaire_id')->nullable()
                ->comment('reference de l urne')
                ->constrained('urne_secondaires')->onDelete('set null');

            $table->foreignId('participant_id')->nullable()
                ->comment('reference du participant')
                ->constrained('participants')->onDelete('set null');

            $table->integer('posi')->default(0)->comment('position de l occurence (base 0)');
            $table->boolean('tire')->default(false)->comment('détermine si le participant est déjà tiré');

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
            $table->dropForeign(['urne_secondaire_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
