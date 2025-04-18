<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeAmountNullableInDownPaymentTable extends Migration
{
    public function up()
    {
        Schema::table('down_payment', function (Blueprint $table) {
            $table->decimal('amount')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('down_payment', function (Blueprint $table) {
            $table->decimal('amount')->nullable(false)->change();
        });
    }
}