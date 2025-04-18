<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('down_payment', function (Blueprint $table) {
            $table->string('img_proof')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('down_payment', function (Blueprint $table) {
            $table->string('img_proof')->nullable(false)->change();
        });
    }

};
