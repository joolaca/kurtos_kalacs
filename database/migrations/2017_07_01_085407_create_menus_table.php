<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    public $table_name = 'menus';

    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('lang', 2)->nullable();
            $table->string('title', 1024)->nullable();
            $table->string('slug', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
