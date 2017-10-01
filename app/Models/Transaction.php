<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id_transaction';

    protected $fillable = [
        'id_transaction', 'id_user', 'id_magasin',
        'id_type_transaction', 'id_paiement', 'id_remise', 'annulee',
    ];

    public static function getNextID()
    {
        $lastRecord = DB::table('transactions')->orderBy('id_transaction', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_transaction + 1);
        return $result;
    }

    public static function createTransactionIN($id_transaction)
    {
        $item = new Transaction();
        $item->id_transaction = $id_transaction;
        $item->id_magasin = Session::get('id_magasin');
        $item->id_user = Session::get('id_user');
        $item->id_type_transaction = Type_transaction::where('libelle', "in")->get()->first()->id_type_transaction;
        $item->annulee = false;
        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de creation de la transaction.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
    }

    public static function createTransactionOUT($id_transaction)
    {
        $item = new Transaction();
        $item->id_transaction = $id_transaction;
        $item->id_magasin = Session::get('id_magasin');
        $item->id_user = Session::get('id_user');
        $item->id_type_transaction = Type_transaction::where('libelle', "OUT")->get()->first()->id_type_transaction;
        $item->annulee = false;
        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de creation de la transaction.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
    }

    public static function createTransactionTransfertOUT($id_transaction, $id_magasin_destination)
    {
        $item = new Transaction();
        $item->id_transaction = $id_transaction;
        $item->id_magasin = $id_magasin_destination;
        $item->id_user = Session::get('id_user');
        $item->id_type_transaction = Type_transaction::where('libelle', "transfertOUT")->get()->first()->id_type_transaction; //4
        $item->annulee = false;
        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de creation de la transaction.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
    }

    public static function createTransactionTransfertIN($id_transaction, $id_magasin_source)
    {
        $item = new Transaction();
        $item->id_transaction = $id_transaction;
        $item->id_magasin = $id_magasin_source;
        $item->id_user = Session::get('id_user');
        $item->id_type_transaction = Type_transaction::where('libelle', "transfertIN")->get()->first()->id_type_transaction; //3
        $item->annulee = false;
        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de creation de la transaction.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
    }

    public static function getNombreArticles($id_transaction)
    {
        return collect(DB::select("select count(distinct(id_article)) as nbre from trans_articles where id_transaction=" . $id_transaction . " "))->first()->nbre;
    }

    public static function getNombrePieces($id_transaction)
    {
        return collect(DB::select("select sum(quantite) as nbre from trans_articles where id_transaction=" . $id_transaction . " "))->first()->nbre;
    }

    public static function getTrans_articles($id_transaction)
    {
        return Trans_article::where('id_transaction',$id_transaction)->get();
    }

}
