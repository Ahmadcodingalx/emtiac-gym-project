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
        Schema::create('groupes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('abonnement_id');
            $table->string(column: 'firstname');
            $table->string(column: 'lastname');
            $table->string(column: 'tel');
            $table->boolean(column: 'sex');
            $table->timestamps();

            $table->foreign('abonnement_id')->references('id')->on('abonnements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupes');
    }
};
