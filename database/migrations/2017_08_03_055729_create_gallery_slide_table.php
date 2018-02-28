<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGallerySlideTable extends Migration
{
    public $table_name = 'gallery_slide';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //@
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->integer('gallery_id')->unsigned()->index();
//            $table->foreign('gallery_id')->references('id')->on('galleris')->onDelete('cascade');
            $table->integer('slide_id')->unsigned()->index();
//            $table->foreign('slide_id')->references('id')->on('slides')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
