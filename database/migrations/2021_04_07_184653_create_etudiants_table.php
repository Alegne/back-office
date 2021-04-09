<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtudiantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cactus_etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('cin');
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->string('adresse');
            $table->enum('status', ['actif', 'ancien'])->default('actif');
            $table->string('photo')->nullable();
            $table->rememberToken();
            $table->timestamps();

            # Key
            # $table->foreignId('niveau_id')
            #     # ->nullable()
            #     ->constrained('cactus_niveaux')
            #     ->onDelete('restrict')
            #     ->onUpdate('restrict');

            $table->foreignId('parcours_id')
                # ->nullable()
                ->constrained('cactus_parcours')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            # $table->foreignId('formation_id')
            #     # ->nullable()
            #     ->constrained('cactus_formations')
            #     ->onDelete('restrict')
            #     ->onUpdate('restrict');

            # $table->foreignId('annee_universitaire_id')
            #     # ->nullable()
            #     ->constrained('cactus_annee_universitaires')
            #     ->onDelete('restrict')
            #     ->onUpdate('restrict');

            # Version verbose
            # $table->unsignedBigInteger('niveau_id');
            # $table->foreign('niveau_id')
            #     ->references('id')
            #     ->on('cactus_niveaux')
            #     ->onDelete('restrict')
            #     ->onUpdate('cascade')
            # ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cactus_etudiants');
    }
}
