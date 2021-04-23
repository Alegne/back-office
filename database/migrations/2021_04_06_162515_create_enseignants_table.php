<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnseignantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cactus_enseignants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('titre');
            $table->string('grade');
            $table->string('identifiant');
            $table->string('mot_de_passe');
            $table->string('email');
            $table->string('telephone');
            $table->string('adresse');
            $table->string('photo')->nullable();

            # $table->timestamp('email_verified_at')->nullable();
            # $table->rememberToken();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cactus_enseignants');
    }
}
