<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutgoingSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('sms-sender.table_name'), function (Blueprint $table) {
            $table->bigIncrements(config('sms-sender.column.primary_key'));
            $table->string(config('sms-sender.column.msisdn'));
            $table->text(config('sms-sender.column.text'));
            $table->string(config('sms-sender.column.sender_name'))->nullable();
            $table->timestamp(config('sms-sender.column.sent_at'))->nullable();
            //$table->text('error')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('sms-sender.table_name'));
    }
}
