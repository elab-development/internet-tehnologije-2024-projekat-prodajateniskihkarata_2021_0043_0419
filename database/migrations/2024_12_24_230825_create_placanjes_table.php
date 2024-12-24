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
            $table->foreign('korisnik_id')->references('id')->on('korisniks')->onDelete('cascade');
            $table->double('iznos');
            $table->timestamp('datum_vreme_transakcije');
            $table->string('status_transakcije');
            $table->string('tip_placanja');
            $table->timestamps();
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
