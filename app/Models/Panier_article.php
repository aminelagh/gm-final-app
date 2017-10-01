<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Panier_article extends Model
{
    protected $table = 'panier_articles';
    protected $primaryKey = 'id_panier_article';

    protected $fillable = [
        'id_panier_article', 'id_panier', 'id_article',
        'id_taille_article', 'quantite', 'annulee',
    ];

    public static function getNextID()
    {
        $lastRecord = DB::table('panier_articles')->orderBy('id_panier_article', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_panier_article + 1);
        return $result;
    }

    public static function createPanierArticle($id_panier, $id_article, $id_taille_article, $quantite)
    {
        $item = new Panier_article();
        $item->id_panier = $id_panier;
        $item->id_article = $id_article;
        $item->id_taille_article = $id_taille_article;
        $item->quantite = $quantite;
        $item->annulee = false;
        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de creation de la transaction.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
    }

    public static function getArticles($id_panier)
    {
        $data = self::where('id_panier', $id_panier)->get();
        return $data;
    }
}
