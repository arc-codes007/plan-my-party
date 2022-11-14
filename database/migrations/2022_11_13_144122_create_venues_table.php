<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->text('address');
            $table->string('gmap_location')->nullable();
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->integer('total_capacity');
            $table->integer('parking_capacity')->default(0);
            $table->json('cuisines')->nullable();
            $table->json('additional_features')->nullable();
            $table->integer('venue_rating')->nullable();
            $table->json('timmings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venues');
    }
}
