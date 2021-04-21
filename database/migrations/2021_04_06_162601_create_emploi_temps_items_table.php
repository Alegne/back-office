<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploiTempsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cactus_emploi_du_temps_items', function (Blueprint $table) {
            $table->id();
            # $table->string('matiere');
            # $table->string('jour'); # jour de la semaine
            $table->dateTime('heure_debut');
            $table->dateTime('heure_fin');
            $table->string('specification');

            # Key
            $table->foreignId('emploi_du_temps_id')
                ->nullable()
                ->constrained('cactus_emploi_du_temps')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreignId('matiere_id')
                ->nullable()
                ->constrained('cactus_matieres')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            # $table->foreignId('enseignant_id')
            #     ->nullable()
            #     ->constrained('cactus_enseignants')
            #     ->onDelete('restrict')
            #     ->onUpdate('restrict');

            # $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cactus_emploi_du_temps_items');
    }
}
