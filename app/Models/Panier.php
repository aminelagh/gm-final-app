<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Panier extends Model
{
    protected $table = 'paniers';
    protected $primaryKey = 'id_panier';

    protected $fillable = [
        'id_panier', 'id_user', 'id_magasin',
        'id_client', 'date','type_vente',
    ];

    public static function getNextID()
    {
        $lastRecord = DB::table('paniers')->orderBy('id_panier', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_panier + 1);
        return $result;
    }

    public static function createPanierClient($id_panier,$type_vente,$id_client)
    {
        $item = new Panier();
        $item->id_panier = $id_panier;
        $item->id_magasin = 1;
        $item->id_user = Session::get('id_user');
        $item->id_client = $id_client;
        $item->type_vente = $type_vente;
        $item->annulee = false;
        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de creation de la transaction.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
    }

    public static function createPanier($id_panier,$type_vente)
    {
        $item = new Panier();
        $item->id_panier = $id_panier;
        $item->id_magasin = 1;
        $item->id_user = Session::get('id_user');
        $item->id_client = null;
        $item->type_vente = $type_vente;
        $item->annulee = false;
        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de creation de la transaction.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
    }

    public static function deletePanier()
    {
        $panier = self::where('id_user',Session::get('id_user'))->get()->first();
        if($panier!=null)
        {
            $id_panier = $panier->id_panier;
            DB::select("delete from paniers where id_panier=".$id_panier." ");
            DB::select("delete from panier_articles where id_panier=".$id_panier." ");
        }

        DB::select("delete from panier_articles where id_panier not in (select id_panier from paniers)");
    }


}
