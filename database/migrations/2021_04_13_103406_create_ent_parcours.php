<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntParcours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cactus_ent_parcours', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            # Key
            $table->foreignId('parcours_id')
                ->nullable()
                ->constrained('cactus_parcours')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreignId('ent_id')
                ->nullable()
                ->constrained('cactus_espace_numeriques')
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
        Schema::dropIfExists('cactus_ent_parcours');
    }
}
