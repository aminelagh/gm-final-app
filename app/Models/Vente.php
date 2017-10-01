<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Vente extends Model
{
    protected $table = 'ventes';
    protected $primaryKey = 'id_vente';

    protected $fillable = [
        'id_vente', 'id_user', 'id_magasin',
        'id_type_transaction', 'id_paiement', 'id_remise', 'annulee',
    ];

    public static function getNextID()
    {
        $lastRecord = DB::table('ventes')->orderBy('id_vente', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_vente + 1);
        return $result;
    }

    public static function createVente($id_vente, $id_mode_paiement, $ref, $id_client)
    {
        try {
            //paiement ------------------------
            $id_paiement = Paiement::getNextID();
            Paiement::creer($id_paiement, $id_mode_paiement, $ref);
            //---------------------------------
            //Vente ---------------------------
            $vente = new Vente();
            $vente->id_vente = $id_vente;
            $vente->id_magasin = Session::get('id_magasin');
            $vente->id_user = Session::get('id_user');
            $vente->id_paiement = $id_paiement;
            $vente->id_remise = null;
            $vente->id_client = $id_client;
            $vente->annulee = false;
            //---------------------------------
            $vente->save();

        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de creation de la transaction.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
    }

    public static function createVenteRemise($id_vente, $id_mode_paiement, $ref, $id_client, $taux, $raison)
    {
        try {

            //remise --------------------------
            $id_remise = Remise::getNextID();
            Remise::creer($id_remise, $taux, $raison);
            //---------------------------------
            //paiement ------------------------
            $id_paiement = Paiement::getNextID();
            Paiement::creer($id_paiement, $id_mode_paiement, $ref);
            //---------------------------------
            //Vente ---------------------------
            $vente = new Vente();
            $vente->id_vente = $id_vente;
            $vente->id_magasin = Session::get('id_magasin');
            $vente->id_user = Session::get('id_user');
            $vente->id_paiement = $id_paiement;
            $vente->id_remise = $id_remise;
            $vente->id_client = $id_client;
            $vente->annulee = false;
            //---------------------------------
            $vente->save();

        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de creation de la transaction.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
    }

    public static function getDate($p_id)
    {
        $data = self::where('id_vente', $p_id)->get()->first();
        if ($data != null)
            return $data->date;
        else return null;
    }

    public static function getMode($p_id)
    {
        $data = self::where('id_paiement', $p_id)->get()->first();
        if ($data != null)
            return Paiement::getMode_Paiement($data->id_paiement);
        else return null;
    }

    public static function getNombreArticles($id_vente)
    {
        return collect(DB::select("select count(distinct(id_article)) as nbre from vente_articles where id_vente=" . $id_vente . " "))->first()->nbre;
    }

    public static function getNombrePieces($id_vente)
    {
        return collect(DB::select("select sum(quantite) as nbre from vente_articles where id_vente=" . $id_vente . " "))->first()->nbre;
    }

    public static function getVente_articles($id_vente)
    {
        return Vente_article::where('id_vente', $id_vente)->get();
    }

}
