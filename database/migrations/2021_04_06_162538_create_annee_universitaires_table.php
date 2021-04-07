<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnneeUniversitairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        # Pivot Etudiant-Niveau-AnneeUniversitaire
        Schema::create('cactus_annee_universitaires', function (Blueprint $table) {
            $table->id();

            # $table->string('libelle');
            # $table->timestamps();

            # Key
            $table->foreignId('niveau_id')
                ->nullable()
                ->constrained('cactus_niveaux')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreignId('etudiant_id')
                ->nullable()
                ->constrained('cactus_etudiants')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreignId('annee_id')
                ->nullable()
                ->constrained('cactus_annee_universitaire_libelles')
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
        Schema::dropIfExists('cactus_annee_universitaires');
    }
}
