<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidesTable extends Migration
{
    public $table_name = 'slides';
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
            $table->integer('category_id')->index();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('file_dir')->nullable();

           /* $table->string('title_hu')->nullable();
            $table->string('content_hu')->nullable();
            $table->string('title_en')->nullable();
            $table->string('content_en')->nullable();
            $table->string('title_de')->nullable();
            $table->string('content_de')->nullable();*/

        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
