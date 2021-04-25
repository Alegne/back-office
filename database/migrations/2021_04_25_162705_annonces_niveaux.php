<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnnoncesNiveaux extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cactus_annonces_niveaux', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            # Key
            $table->foreignId('niveau_id')
                ->nullable()
                ->constrained('cactus_niveaux')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreignId('annonce_id')
                ->nullable()
                ->constrained('cactus_annonces')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cactus_annonces_niveaux');
    }
}
