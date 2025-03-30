<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Assuming you have run "php artisan migrate" and number on downpayment was not change.
     *  Run "php artisan migrate" to update the number on downpayment to ref_num.
     */
    public function up()
    {
        Schema::table('down_payment', function (Blueprint $table) {
            $table->renameColumn('number', 'ref_num');
        });
    }

    public function down()
    {
        Schema::table('down_payment', function (Blueprint $table) {
            $table->renameColumn('ref_num', 'number');
        });
    }

};
