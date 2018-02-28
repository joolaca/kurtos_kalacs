<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    public $table_name = 'categories';
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
            $table->string('type');
            $table->string('slug');
            $table->text('description')->nullable();

            //polymorph kapcsolathoz kell
            $table->unsignedInteger('categorizable_id')->nullable()->index();
            $table->integer('categorizable_type')->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
