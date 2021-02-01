<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateStatusesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'statuses';
    public $table_comment = 'statuses of objects in the system.';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');

            $table->string('name')->comment('status name');
            $table->string('code', 100)->unique()->comment('status code');

            $table->boolean('is_default')->default(false)->comment('determine whether is the default one.');

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
