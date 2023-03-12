<?php

use App\Models\Package;
use App\Models\Party;
use App\Models\Venue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Venue::class);
            $table->foreignIdFor(Package::class)->nullable();
            $table->foreignIdFor(Party::class);
            $table->enum('user_type', ['user', 'guest']);
            $table->foreignId('user_id');
            $table->integer('rating');
            $table->text("review");
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
        Schema::dropIfExists('reviews');
    }
}
