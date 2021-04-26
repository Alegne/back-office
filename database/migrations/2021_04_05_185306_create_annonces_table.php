<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnoncesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cactus_annonces', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->longText('description');
            $table->boolean('approuve')->default(false);
            $table->enum('type', array('public', 'private'))
                ->default('public');
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
        Schema::dropIfExists('cactus_annonces');
    }
}
