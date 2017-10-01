<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Stock_taille extends Model
{
    protected $table = 'stock_tailles';
    protected $primaryKey = 'id_stock_taille';


    protected $fillable = [
        'id_stock', 'id_stock_taille', 'id_taille_article',
        'quantite',
    ];

    public static function hasTailles($id_stock)
    {
        $x = self::where('id_stock', $id_stock)->get();
        if ($x->isEmpty())
            return false;
        else return true;
    }

    public static function getTailles($id_stock)
    {
        return self::where('id_stock', $id_stock)->get();
    }

    public static function tailleExiste($id_stock, $id_taille_article)
    {
        $x = Stock_taille::where('id_stock', $id_stock)->where('id_taille_article', $id_taille_article)->get();
        if (!$x->isEmpty())
            return true;
        else return false;
    }

    public static function incrementer($p_id_stock, $p_id_taille_article, $p_quantite)
    {
        $item = self::where('id_stock', $p_id_stock)->where('id_taille_article', $p_id_taille_article)->get()->first();
        try {
            $item->update([
                'quantite' => ($item->quantite + $p_quantite)
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
    }

    public static function decrementer($p_id_stock, $p_id_taille_article, $p_quantite)
    {
        //$item = self::where('id_stock', $p_id_stock)->where('id_taille_article', $p_id_taille_article)->get()->first();
        try {
            //$item->update(['quantite' => ($item->quantite - $p_quantite)]);
            DB::select("update stock_tailles set quantite = quantite-" . $p_quantite . " where id_stock=" . $p_id_stock . " AND id_taille_article=" . $p_id_taille_article . " ; ");
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
    }

    public static function create($id_stock, $id_taille_article, $quantite)
    {
        $item = new Stock_taille();
        $item->id_stock = $id_stock;
        $item->id_taille_article = $id_taille_article;
        $item->quantite = $quantite;
        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur.<br>Message d'erreur:<b>" . $e->getMessage() . "</b>.");
        }
    }

    public static function deleteEmptyItems()
    {
        $data = DB::select("delete from stock_tailles where quantite=0");
        //$data = DB::select("show tables");
        //dump($data);
    }
}
