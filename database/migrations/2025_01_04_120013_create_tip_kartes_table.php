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
            $table->string('ime_tipa_karte');
            $table->decimal('cena', 8, 2);
            $table->text('opis_benefita');
            $table->integer('broj_benefita');
            $table->unsignedBigInteger('dogadjaj_id');
            $table->timestamps();

            // Definisanje stranog ključa
            $table->foreign('dogadjaj_id')->references('id')->on('dogadjajs')->onDelete('cascade');
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
