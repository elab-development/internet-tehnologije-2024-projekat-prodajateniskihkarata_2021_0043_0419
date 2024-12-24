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
        Schema::create('tip_kartes', function (Blueprint $table) {
            $table->id();
            $table->string('naziv_tipa_karte');
            $table->double('cena');
            $table->text('opis_pogodnosti');
            $table->integer('broj_pogodnosti');
            $table->unsignedBigInteger('dogadjaj_id');
            $table->foreign('dogadjaj_id')->references('id')->on('dogadjajs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tip_kartes');
    }
};
