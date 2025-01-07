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
        Schema::create('korisniks', function (Blueprint $table) {
            $table->id();
            $table->string('ime');
            $table->string('email')->unique();
            $table->string('lozinka');
            $table->string('uloga');
            $table->timestamp('datum_registracije')->nullable();
            //$table->foreignId('dogadjaj_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('korisniks');
    }
};
