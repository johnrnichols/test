<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo', function($table) {
        	$table->string('MediaModificationTimestamp');
        	$table->string('MediaURL',2047);
            $table->string('ListingKey');
            $table->foreign('ListingKey')->references('ListingKey')->on('listing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('photo');
    }
}
