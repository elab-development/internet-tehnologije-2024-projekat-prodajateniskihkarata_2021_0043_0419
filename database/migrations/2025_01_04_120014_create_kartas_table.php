<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kartas', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('korisnik_id');
            $table->unsignedBigInteger('dogadjaj_id');
            $table->unsignedBigInteger('tip_karte_id');
            $table->string('status_karte');
            $table->string('qr_kod');
            $table->timestamps();
    
            // Definisanje stranih ključeva
            $table->foreign('korisnik_id')->references('id')->on('korisniks')->onDelete('cascade');
            $table->foreign('dogadjaj_id')->references('id')->on('dogadjajs')->onDelete('cascade');
            $table->foreign('tip_karte_id')->references('id')->on('tip_kartes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartas');
    }
};
