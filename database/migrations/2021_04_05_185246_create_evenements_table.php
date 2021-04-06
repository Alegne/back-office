<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvenementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cactus_evenements', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->longText('description');
            $table->dateTime('date_creation');
            $table->string('posteur');
            $table->string('slug');
            $table->enum('type', array('actualite', 'nouvelle'))
                ->default('nouvelle');
            $table->string('image')->nullable();
            $table->string('galerie')->nullable();
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
        Schema::dropIfExists('cactus_evenements');
    }
}
