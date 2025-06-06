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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Qui a enregistré la transaction
            $table->enum('type', ['in', 'out']); // Dépense ou revenu
            $table->enum('category', ['abb', 'sale', 'salary', 'refund', 'other', 'purchase']);
            $table->decimal('amount', 15, 2); // Montant de la transaction
            $table->string('reason')->nullable(); // Motif de la transaction
            $table->unsignedBigInteger('abb_id')->nullable();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('abb_id')->references('id')->on('abonnements')->onDelete('set null');
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
