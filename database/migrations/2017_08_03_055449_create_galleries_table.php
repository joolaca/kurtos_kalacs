<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesTable extends Migration
{
    public $table_name = 'galleries';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //@
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
