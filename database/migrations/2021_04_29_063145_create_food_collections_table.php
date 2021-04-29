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
            $table->string('card_number');
            $table->string('department');
            $table->string('paynumber');
            $table->string('collected_by')->default('self');
            $table->string('id_number')->nullable();
            $table->string('name');
            $table->string('date_collected');
            $table->string('done_by');
            $table->softDeletes();
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
