<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cactus_articles', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->longText('description');
            $table->string('posteur');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->string('galerie')->nullable();
            $table->timestamps();


            $table->foreignId('club_id')
                ->nullable()
                ->constrained('cactus_clubs')
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
        Schema::dropIfExists('cactus_articles');
    }
}
