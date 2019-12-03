<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldSubscriberTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('field_subscriber', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subscriber_id');
            $table->unsignedBigInteger('field_id');
            $table->string('value')->nullable();

            $table->foreign('subscriber_id')
                ->references('id')->on('subscribers')
                ->onDelete('cascade');

            $table->foreign('field_id')
                ->references('id')->on('fields')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('field_subscriber');
    }
}
