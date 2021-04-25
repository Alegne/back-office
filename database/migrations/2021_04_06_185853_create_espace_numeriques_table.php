<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspaceNumeriquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cactus_espace_numeriques', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->longText('description');
            $table->string('pieces_jointes')->nullable();
            $table->timestamps();

            # Key
            $table->foreignId('niveau_id')
                ->nullable()
                ->constrained('cactus_niveaux')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            # $table->foreignId('parcours_id')
            #     ->nullable()
            #     ->constrained('cactus_parcours')
            #     ->onDelete('restrict')
            #     ->onUpdate('restrict');

            $table->foreignId('enseignant_id')
                ->nullable()
                ->constrained('cactus_enseignants')
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
        Schema::dropIfExists('cactus_espace_numeriques');
    }
}
