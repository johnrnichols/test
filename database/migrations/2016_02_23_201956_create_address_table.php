<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function($table) {
        	$table->string('FullStreetAddress');
        	$table->string('City');
        	$table->string('StateOrProvince');
        	$table->string('PostalCode');
        	$table->string('Country');
        	$table->string('ListingKey');
        	$table->foreign('ListingKey')->references('ListingKey')->on('listing');
            $table->unique('ListingKey');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('address');
    }
}
