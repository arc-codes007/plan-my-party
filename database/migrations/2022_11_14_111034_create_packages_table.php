<?php

use App\Models\Venue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Venue::class);
            $table->string('name');
            $table->string('type');
            $table->json('menu')->nullable();
            $table->json('billing_config');
            $table->decimal('cost', 10, 2);
            $table->integer('min_persons');
            $table->integer('max_persons');
            $table->string('venue_type');
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->json('additional_details')->nullable();
            $table->json('timmings');
            $table->boolean('active');
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
        Schema::dropIfExists('packages');
    }
}
