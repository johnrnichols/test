<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing', function($table) {
        	$table->string('ListingKey');
        	$table->primary('ListingKey');
        	$table->integer('ListPrice');
        	$table->string('ListingURL', 2047);
        	$table->string('ListingDescription', 2047);
            $table->dateTime('ListingDate');
        	$table->boolean('DiscloseAddress');
        	$table->integer('Bedrooms');
        	$table->integer('Bathrooms');
        	$table->integer('MlsNumber');
            $table->unique('MlsNumber');
            $table->string('MlsId');
            $table->foreign('MlsId')->references('MlsId')->on('mls');
        	$table->integer('PropertyType')->unsigned();
        	$table->foreign('PropertyType')->references('id')->on('type');
        	$table->integer('ListingCategory')->unsigned();
        	$table->foreign('ListingCategory')->references('id')->on('category');
        	$table->integer('ListingStatus')->unsigned();
        	$table->foreign('ListingStatus')->references('id')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('listing');
    }
}
