<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_collections', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->string('jobcard');
            $table->string('collected_by')->default('self');
            $table->string('id_number')->nullable();
            $table->string('emplyee_name');
            $table->string('collection_date');
            $table->string('done_by');
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
        Schema::dropIfExists('food_collections');
    }
}
