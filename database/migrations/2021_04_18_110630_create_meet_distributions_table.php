<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meet_distributions', function (Blueprint $table) {
            $table->id();
            $table->string('department');
            $table->string('paynumber');
            $table->string('name');
            $table->string('card_number');
            $table->date('issue_date');
            $table->string('month');
            $table->string('collected_by')->default('self');
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
        Schema::dropIfExists('meet_distributions');
    }
}
