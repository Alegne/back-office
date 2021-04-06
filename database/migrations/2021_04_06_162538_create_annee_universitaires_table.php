<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnneUniversitairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cactus_annee_universitaires', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            # $table->timestamps();

            # Key
            # $table->foreignId('niveau_id')
            #     # ->nullable()
            #     ->constrained('cactus_niveaux')
            #     ->onDelete('restrict')
            #     ->onUpdate('restrict');
            # $table->foreignId('formation_id')
            #     # ->nullable()
            #     ->constrained('cactus_formations')
            #     ->onDelete('restrict')
            #     ->onUpdate('restrict');
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
