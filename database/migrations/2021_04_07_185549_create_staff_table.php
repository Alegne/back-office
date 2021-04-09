<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cactus_staff', function (Blueprint $table) {
            $table->id();
            $table->enum('type', array('leader', 'membre'))
                ->default('membre');
            $table->timestamps();

            # Key
            $table->foreignId('club_id')
                # ->nullable()
                ->constrained('cactus_clubs')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            # Key
            $table->foreignId('etudiant_id')
                # ->nullable()
                ->constrained('cactus_etudiants')
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
        Schema::dropIfExists('cactus_staff');
    }
}
