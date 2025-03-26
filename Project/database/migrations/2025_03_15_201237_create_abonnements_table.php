<?php

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
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('user_create_id')->nullable();
            $table->unsignedBigInteger('user_update_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal(column: 'price')->nullable();
            $table->enum('status', ['actif', 'expiré', 'suspendu', 'attente'])->default('attente');
            $table->string('sale_mode')->default('cash');
            $table->string(column: 'transaction_id')->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();

            $table->foreign('user_create_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('user_update_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('set null');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonnements');
    }
};
