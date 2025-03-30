<?php
//  Assuming you have run "php artisan migrate" already, you need to run this to set verified_by to nullable
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('down_payment', function (Blueprint $table) {
            $table->string('verified_by')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('down_payment', function (Blueprint $table) {
            $table->string('verified_by')->nullable(false)->change();
        });
    }
};
