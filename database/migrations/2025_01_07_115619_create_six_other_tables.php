<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('password', 50);
            $table->string('number',11);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('inactive_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id'); // customer_id references customers table
            $table->timestamp('inactive_date');
            $table->text('deletion_reason');
            $table->unsignedBigInteger('archived_by');

            $table->foreign('archived_by')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('number', 11);
            $table->string('email', 255)->unique();
            $table->string('password', 50);
            $table->string('role', 50);
            $table->timestamps();
        });

        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->decimal('price');
            $table->string('type', 255);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('added_by');
            $table->timestamps();

            $table->foreign('added_by')->references('id')->on('admins')->onDelete('cascade');
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('customer_id');
            $table->timestamp('date');
            $table->timestamp('startTime');
            $table->timestamp('endTime');
            $table->enum('status', ['verified', 'pending', 'cancelled', 'invalid', 'completed']);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });

        Schema::create('reserved_amenity', function (Blueprint $table) {
            $table->id();
            $table->uuid('res_num'); 
            $table->unsignedBigInteger('amenity_id');

            $table->foreign('res_num')->references('id')->on('reservations')->onDelete('cascade');
            $table->foreign('amenity_id')->references('id')->on('amenities')->onDelete('cascade');
        });

        Schema::create('bills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('res_num'); 
            $table->decimal('grand_total');
            $table->timestamp('date');
            $table->enum('status', ['paid', 'partially paid', 'unpaid']);

            $table->foreign('res_num')->references('id')->on('reservations')->onDelete('cascade');
        });

        Schema::create('down_payment', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('res_num'); 
            $table->decimal('amount');
            $table->string('number', 11);
            $table->string('img_proof', 255);
            $table->timestamp('date');
            $table->enum('status', ['verified', 'pending', 'invalid']);
            $table->unsignedBigInteger('verified_by');

            $table->foreign('verified_by')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('res_num')->references('id')->on('reservations')->onDelete('cascade');
        });

        Schema::create('balance', function (Blueprint $table) {
            $table->id();
            $table->uuid('bill_id'); 
            $table->uuid('dp_id'); 
            $table->decimal('balance');
            $table->enum('status', ['paid', 'partially paid']);
            $table->timestamps();
            $table->unsignedBigInteger('received_by')->nullable();

            $table->foreign('received_by')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('dp_id')->references('id')->on('down_payment')->onDelete('cascade');
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade');
            DB::statement("UPDATE sqlite_sequence SET seq = 4999 WHERE name = 'balance'");
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
        Schema::dropIfExists('inactive_customers');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('amenities');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('reserved_amenity');
        Schema::dropIfExists('bills');
        Schema::dropIfExists('down_payment');
        Schema::dropIfExists('balance');
    }
};
