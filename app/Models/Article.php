<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Session;

class Article extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id_article';

    protected $fillable = [
        'id_article', 'id_fournisseur', 'id_categorie', 'id_marque',
        'designation',
        'code', 'ref', 'alias',
        'couleur', 'sexe', 'prix_a', 'prix_v',
        'deleted', 'image', 'valide'
    ];

    public static function applyTaux($prix, $taux)
    {
        return ($prix - ($prix * $taux / 100));
    }

    public static function getPrixPromo($p_id_article)
    {
        $p_id_magasin = Session::get('id_magasin');
        $prixHT = Article::where('id_article', $p_id_article)->first()->prix_vente;
        $prixTTC = $prixHT * 1.2;

        if (Promotion::hasPromotion($p_id_article, $p_id_magasin)) {
            $taux = Promotion::getTauxPromo($p_id_article, $p_id_magasin);
            $prix = self::applyTaux($prixTTC, $taux); //$prixTTC * (1 - $taux / 100);
            return $prix;
        } else {
            return $prixTTC;
        }
    }

    public static function getPrixPromoSimple($p_id_article)
    {
        $p_id_magasin = Session::get('id_article');
        $prixHT = Article::where('id_article', $p_id_article)->first()->prix_v;
        $prixTTC = $prixHT * 1.2;

        if (Promotion::hasPromotion($p_id_article)) {
            $taux = Promotion::getTauxPromo($p_id_article);
            $prix = self::applyTaux($prixTTC, $taux);
            return $prix;
        } else {
            return $prixTTC;
        }
    }

    public static function getPrixPromoGros($p_id_article)
    {
        $p_id_magasin = Session::get('id_article');
        $prixHT = Article::where('id_article', $p_id_article)->first()->prix_vente;
        $prixTTC = $prixHT * 1.2;

        if (Promotion::hasPromotion($p_id_article, $p_id_magasin)) {
            $taux = Promotion::getTauxPromo($p_id_article, $p_id_magasin);
            $prix = $prixTTC * (1 - $taux / 100);
            return $prix;
        } else {
            return $prixTTC;
        }
    }

    static function getNextID()
    {
        $lastRecord = DB::table('articles')->orderBy('id_article', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_article + 1);
        return $result;
    }

    public static function CodeExists($code)
    {
        $data = self::where('code', $code)->get()->first();
        if ($data == null)
            return false;
        else return true;
    }

    public static function hasNonValideArticles()
    {
        $data = self::where('valide', false)->where('deleted', false)->get();
        if ($data->isEmpty())
            return false;
        else return true;
    }

    public static function ValideArticles($id_article)
    {
        $data = self::where('id_article', $id_article)->where('valide', false)->where('deleted', false)->get();
        if ($data->isEmpty())
            return false;
        else return true;
    }

    public static function nonValideArticles()
    {
        return self::where('valide', false)->where('deleted', false)->get();
    }

    public static function CodeExistForUpdate($p_id, $code)
    {
        $x = self::where('code', $code)->where('id_article', '!=', $p_id)->first();
        if ($x == null)
            return false;
        else
            return true;
    }

    public static function HTtoTTC($prix_HT)
    {
        return number_format($prix_HT * 1.2, 2);
    }

    //Getters
    public static function getMarque($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return Marque::getLibelle($data->id_marque);
        else return null;
    }

    public static function getCategorie($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return Categorie::getLibelle($data->id_categorie);
        else return null;
    }

    public static function getFournisseur($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return Fournisseur::getLibelle($data->id_fournisseur);
        else return null;
    }

    public static function getDesignation($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return $data->designation;
        else return null;
    }

    public static function getCode($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return $data->code;
        else return null;
    }

    public static function getRef($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return $data->ref;
        else return null;
    }

    public static function getAlias($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return $data->alias;
        else return null;
    }

    public static function getSexe($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return $data->sexe;
        else return null;
    }

    public static function getCouleur($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return $data->couleur;
        else return null;
    }

    public static function getPrixTTC($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return number_format(($data->prix_v * 1.2), 2);
        else return null;
    }

    public static function getPrixHT($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return number_format($data->prix_v, 2);
        else return null;
    }

    public static function getPrixGrosTTC($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return number_format(($data->prix_v * 1.2), 2);
        else return null;
    }

    public static function getPrixGrosHT($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return number_format($data->prix_v, 2);
        else return null;
    }

    public static function getPrixAchatHT($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return number_format($data->prix_a, 2);
        else return null;
    }

    public static function getPrixAchatTTC($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return number_format($data->prix_a * 1.2, 2);
        else return null;
    }

    public static function getImage($p_id)
    {
        $data = self::where('id_article', $p_id)->get()->first();
        if ($data != null)
            return $data->image;
        else return null;
    }
}
