<?php

/**
 * Part of the Sentinel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Sentinel
 * @version    2.0.15
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2017, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MigrationCartalystSentinel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('code');
            $table->boolean('completed')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        Schema::create('persistences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('code');
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->unique('code');
        });

        Schema::create('reminders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('code');
            $table->boolean('completed')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('name');
            $table->text('permissions')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->unique('slug');
        });

        Schema::create('role_users', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->nullableTimestamps();

            $table->engine = 'InnoDB';
            $table->primary(['user_id', 'role_id']);
        });

        Schema::create('throttle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('type');
            $table->string('ip')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index('user_id');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_magasin')->nullable();

            $table->string('email');
            $table->string('password');

            $table->text('permissions')->nullable();
            $table->timestamp('last_login')->nullable();

            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('ville')->nullable();
            $table->string('telephone')->nullable();

            $table->boolean('deleted');
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->unique('email');
        });

        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->increments('id_fournisseur');
            $table->string('code');
            $table->string('libelle');
            $table->boolean('deleted');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id_categorie');
            $table->string('libelle');
            $table->boolean('deleted');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('marques', function (Blueprint $table) {
            $table->increments('id_marque');
            $table->string('libelle');
            $table->string('image')->nullable();
            $table->boolean('deleted');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('agents', function (Blueprint $table) {
            $table->increments('id_agent');
            $table->integer('id_fournisseur');
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('role');
            $table->string('ville')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('deleted');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id_article');
            $table->integer('id_fournisseur');
            $table->integer('id_categorie');
            $table->integer('id_marque');

            $table->string('code')->nullable();
            $table->string('ref');
            $table->string('alias')->nullable();

            $table->string('couleur')->nullable();
            $table->string('sexe')->nullable();
            $table->double('prix_a')->nullable();
            $table->double('prix_v')->nullable();
            $table->text('designation');

            $table->string('image',255)->nullable();

            $table->boolean('deleted');
            $table->boolean('valide')->nullable();

            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('magasins', function (Blueprint $table) {
            $table->increments('id_magasin');
            $table->string('libelle');
            $table->string('ville')->nullable();

            $table->text('adresse')->nullable();
            $table->string('agent')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();

            $table->boolean('deleted');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id_stock');
            $table->integer('id_magasin');
            $table->integer('id_article');

            $table->integer('quantite_min')->nullable();
            $table->integer('quantite_max')->nullable();

            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('stock_tailles', function (Blueprint $table) {
            $table->increments('id_stock_taille');
            $table->integer('id_stock');
            $table->integer('id_taille_article')->nullable();

            $table->integer('quantite')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('taille_articles', function (Blueprint $table) {
            $table->increments('id_taille_article');
            $table->string('taille');

            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //Entree & sortie de stock
        Schema::create('type_transactions', function (Blueprint $table) {
            $table->increments('id_type_transaction');
            $table->string('libelle')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id_transaction');
            $table->integer('id_magasin');
            $table->integer('id_user');
            $table->integer('id_type_transaction');

            $table->dateTime('date');
            $table->boolean('annulee')->nullable();

            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('trans_articles', function (Blueprint $table) {
            $table->increments('id_trans_article');
            $table->integer('id_transaction');
            $table->integer('id_article');
            $table->integer('id_taille_article')->nullable();

            $table->integer('quantite');
            $table->boolean('annulee')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //Ventes
        //numero du ticket = id_vente
        Schema::create('paiements', function (Blueprint $table) {
            $table->increments('id_paiement');
            $table->integer('id_mode_paiement');
            $table->string('ref')->nullable();

            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('remises', function (Blueprint $table) {
            $table->increments('id_remise');
            $table->integer('taux');
            $table->string('raison')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('mode_paiements', function (Blueprint $table) {
            $table->increments('id_mode_paiement');
            $table->string('libelle');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('ventes', function (Blueprint $table) {
            $table->increments('id_vente');
            $table->integer('id_magasin');
            $table->integer('id_user');
            $table->integer('id_paiement');
            $table->integer('id_remise')->nullable();
            $table->integer('id_client');

            $table->dateTime('date');
            $table->boolean('annulee')->nullable();

            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('vente_articles', function (Blueprint $table) {
            $table->increments('id_vente_article');
            $table->integer('id_vente');
            $table->integer('id_article');
            $table->integer('id_promotion')->nullable();
            $table->integer('id_taille_article')->nullable();

            $table->double('prix');
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
        Schema::drop('activations');
        Schema::drop('persistences');
        Schema::drop('reminders');
        Schema::drop('roles');
        Schema::drop('role_users');
        Schema::drop('throttle');
        Schema::drop('users');
    }
}
