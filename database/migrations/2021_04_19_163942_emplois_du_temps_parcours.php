<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmploisDuTempsParcours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        # Pivot EmploiDuTemps-Parcours
        Schema::create('cactus_emploi_du_temps_parcours', function (Blueprint $table) {
            $table->id();

            # $table->string('libelle');
            $table->timestamps();

            # Key
            $table->foreignId('parcours_id')
                ->nullable()
                ->constrained('cactus_parcours')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreignId('emploi_du_temps_id')
                ->nullable()
                ->constrained('cactus_emploi_du_temps')
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
        Schema::dropIfExists('cactus_emploi_du_temps_parcours');
    }
}
