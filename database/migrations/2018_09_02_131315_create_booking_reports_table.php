<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_reports', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('booking_location_id')->index()->unsigned();
            $table->integer('booking_category_id')->index()->unsigned();
            $table->integer('booking_type_id')->index()->unsigned();
            $table->integer('booking_time_id')->index()->unsigned();

            $table->date('booking_date');
            $table->integer('quantity')->index()->unsigned()->default(0);

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
        Schema::dropIfExists('booking_reports');
    }
}
