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
        Schema::create('placanjes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('korisnik_id');
            $table->decimal('iznos', 8, 2);
            $table->timestamp('datum_transakcije');
            $table->string('status_transakcije');
            $table->string('tip_placanja');
            $table->timestamps();
    
            // Dodavanje indeksa za strani ključ 
            $table->index('korisnik_id');
    
            // Definisanje stranog ključa sa referencama 
            $table->foreign('korisnik_id')->references('id')->on('korisniks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('placanjes');
    }
};
