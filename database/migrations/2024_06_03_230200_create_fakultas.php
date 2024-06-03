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
        Schema::create('fakultas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_fakultas');
            $table->timestamps();
        });

        Schema::table('login', function (Blueprint $table) {
            $table->unsignedBigInteger('fakultas_id')->nullable();

            $table->foreign("fakultas_id")->references("id")->on("fakultas")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fakultas');
    }
};
