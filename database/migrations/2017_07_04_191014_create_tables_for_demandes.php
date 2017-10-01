<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesForDemandes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->increments('id_demande');
            $table->integer('id_magasin')->nullable();
            $table->integer('id_user')->nullable();
            $table->integer('id_paiement')->nullable();
            $table->integer('id_remise')->nullable();
            $table->integer('id_promotion')->nullable();
            $table->integer('id_client')->nullable();

            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->boolean('annulee')->nullable();

            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('demande_articles', function (Blueprint $table) {
            $table->increments('id_demande_article');
            $table->integer('id_demande');
            $table->integer('id_article');
            $table->integer('id_taille_article')->nullable();

            $table->double('prix')->nullable();
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
        Schema::dropIfExists('demandes');
        Schema::dropIfExists('demande_articles');
    }
}
