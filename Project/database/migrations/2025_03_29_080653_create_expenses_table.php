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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Qui a enregistré la transaction
            $table->enum('type', ['salary', 'refund', 'invoice', 'purchase', 'other']); // Dépense ou revenu
            $table->dateTime('date');
            $table->decimal('amount', 15, 2); // Montant de la transaction
            $table->string('reason')->nullable(); // Motif de la transaction
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
