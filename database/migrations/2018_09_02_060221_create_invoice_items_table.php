<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('invoice_id')->index()->unsigned();

            $table->integer('booking_location_id')->index()->unsigned();
            $table->integer('booking_category_id')->index()->unsigned();
            $table->integer('booking_type_id')->index()->unsigned();
            $table->integer('booking_time_id')->index()->unsigned();

            $table->date('booking_date');
            $table->decimal('price', 9, 2)->unsigned();
            $table->integer('quantity')->index()->unsigned();

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
        Schema::dropIfExists('invoice_items');
    }
}
