<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndexPageTable extends Migration
{
    public $table_name = 'index_pages';
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
            $table->string('lang');
            $table->string('type');
            $table->integer('gallery_id')->nullable();
            $table->integer('slide_id')->nullable();
            $table->text('title')->nullable();
            $table->text('content')->nullable();
            $table->text('description')->nullable();
            $table->text('href')->nullable();
            $table->text('href2')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
