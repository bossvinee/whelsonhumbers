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
            $table->string('allocation');
            $table->string('done_by');
            $table->string('status')->default('Not Collected');
            $table->date('date_collected')->nullable();
            $table->string('collected_by')->default('Not Collected');
            $table->string('id_number')->nullable();
            $table->string('meet_a');
            $table->string('meet_b');
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
