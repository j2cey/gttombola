<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateProductsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'products';
    public $table_comment = 'products list';

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

            $table->string('name');
            $table->float('price')->default(0);

            $table->timestamps();
        });
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
        });
        Schema::dropIfExists($this->table_name);
    }
}
