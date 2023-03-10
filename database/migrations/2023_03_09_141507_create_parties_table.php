<?php

use App\Models\Package;
use App\Models\Venue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Venue::class);
            $table->foreignIdFor(Package::class)->nullable();
            $table->enum('type', ['standard', 'custom']);
            $table->string('status');
            $table->timestamp('date')->useCurrent();
            $table->json('timming')->nullable();
            $table->integer('person_count')->nullable();
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
        Schema::dropIfExists('parties');
    }
}
