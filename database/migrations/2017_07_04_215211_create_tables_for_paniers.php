<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesForPaniers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {       

        Schema::create('paniers', function (Blueprint $table) {
            $table->increments('id_panier');
            $table->integer('id_magasin')->nullable();
            $table->integer('id_user')->nullable();
            $table->integer('id_client')->nullable();
            $table->string('type_vente')->nullable();
            $table->boolean('annulee')->nullable();

            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('panier_articles', function (Blueprint $table) {
            $table->increments('id_panier_article');
            $table->integer('id_panier');
            $table->integer('id_article');
            $table->integer('id_taille_article')->nullable();
            $table->integer('quantite');
            $table->boolean('annulee')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paniers');
        Schema::dropIfExists('panier_articles');
    }
}
