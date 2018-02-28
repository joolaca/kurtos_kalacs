<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLangTable extends Migration
{
    public $table_name = 'langs';

    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->increments('id');
            $table->string('lang', 2)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('body_class', 64)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
