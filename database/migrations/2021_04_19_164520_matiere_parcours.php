<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MatiereParcours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        # Pivot Matiere-Parcours
        Schema::create('cactus_matiere_parcours', function (Blueprint $table) {
            $table->id();

            # $table->string('libelle');
            $table->timestamps();

            # Key
            $table->foreignId('parcours_id')
                ->nullable()
                ->constrained('cactus_parcours')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreignId('matiere_id')
                ->nullable()
                ->constrained('cactus_matieres')
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
        Schema::dropIfExists('cactus_matiere_parcours');
    }
}
