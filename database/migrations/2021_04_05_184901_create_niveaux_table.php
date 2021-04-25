<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNiveauxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cactus_niveaux', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('tag');

            # $table->timestamps();

            # Key
            $table->foreignId('formation_id')
                ->nullable()
                ->constrained('cactus_formations')
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
        Schema::dropIfExists('cactus_niveaux');
    }
}
