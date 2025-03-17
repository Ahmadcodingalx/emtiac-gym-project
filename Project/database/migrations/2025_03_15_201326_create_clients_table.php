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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id_create')->nullable();
            $table->unsignedBigInteger('user_id_update')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->text('image');
            $table->string('email')->nullable();
            $table->string('tel');
            $table->string('identifiant');
            $table->text('address')->nullable();
            $table->boolean('sex')->nullable();
            $table->timestamps();

            $table->foreign('user_id_create')->references('id')->on('users')->onDelete('set null');
            $table->foreign('user_id_update')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
