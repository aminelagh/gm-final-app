<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trans_article extends Model
{
    protected $table = 'trans_articles';
    protected $primaryKey = 'id_tras_article';

    protected $fillable = [
      'id_tras_article', 'id_transaction','id_article' ,
      'quantite', 'prix'
    ];

    public static function getNextID()
    {
        $lastRecord = DB::table('trans_articles')->orderBy('id_trans_article', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_trans_article + 1);
        return $result;
    }

    public static function create($id_transaction, $id_article,$id_taille_article,$quantite)
    {
        $item = new Trans_article();
        $item->id_transaction = $id_transaction;
        $item->id_article = $id_article;
        $item->id_taille_article = $id_taille_article;
        $item->quantite = $quantite;
        $item->annulee = false;

        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur.<br>Message d'erreur:<b>" . $e->getMessage() . "</b>.");
        }

    }
}
