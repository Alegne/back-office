<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatieresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cactus_matieres', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('libelle');
            $table->string('couleur')->nullable();

            # Key
            $table->foreignId('enseignant_id')
                ->nullable()
                ->constrained('cactus_enseignants')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreignId('niveau_id')
                ->nullable()
                ->constrained('cactus_niveaux')
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
        Schema::dropIfExists('cactus_matieres');
    }
}
