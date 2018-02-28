<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThumbnailSizesTable extends Migration
{
    public $table_name = 'thumbnail_sizes';
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
            $table->string('prefix');
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('description')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
