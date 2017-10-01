<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Vente_article extends Model
{
    protected $table = 'vente_articles';
    protected $primaryKey = 'id_vente_article';

    protected $fillable = [
        'id_vente_article', 'id_vente', 'id_article', 'id_promotion',
        'id_taille_article', 'quantite', 'prix', 'annulee',
    ];

    public static function getNextID()
    {
        $lastRecord = DB::table('vente_articles')->orderBy('id_vente_article', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_vente_article + 1);
        return $result;
    }

    public static function create($id_vente, $id_article, $id_taille_article, $prix, $id_promotion, $quantite)
    {
        $item = new Vente_article();
        $item->id_vente = $id_vente;
        $item->id_article = $id_article;
        $item->id_taille_article = $id_taille_article;
        $item->quantite = $quantite;
        $item->id_promotion = $id_promotion;
        $item->prix = $prix;
        $item->annulee = false;

        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur.<br>Message d'erreur:<b>" . $e->getMessage() . "</b>.");
        }

    }

    public static function getNombreArticles($id_vente)
    {
        if (!Vente_article::hasTailles($id_vente))
            return 0;
        else {
            $tailles = Vente_article::getTailles($id_vente);
            $nbreArticles = 0;
            foreach ($tailles as $item) {
                $nbreArticles += $item->quantite;
            }
        }
        return $nbreArticles;
    }

    public static function getTaille($p_id)
    {
        $data = self::where('id_taille_article', $p_id)->get()->first();
        if ($data != null)
            return Taille_article::getTaille($data->id_taille_article);
        else return null;
    }

    public static function getQuantite($p_id)
    {
        $data = self::where('id_vente_article', $p_id)->get()->first();
        if ($data != null)
            return $data->quantite;
        else return null;
    }

    public static function hasTailles($id_vente_article)
    {
        $x = self::where('id_vente_article', $id_vente_article)->get();
        if ($x->isEmpty())
            return false;
        else return true;
    }
}
