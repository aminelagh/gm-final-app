<?php
/*
Helper pour le adminController
*/

use Carbon\Carbon;
use App\Models\Promotion;


// verifier si l'article du magasin est en periode de promotion
if (!function_exists('hasPromotion')) {
    function hasPromotion($p_id_article)
    {
        $p_id_magasin = Session::get('id_magasin');
        $promo = collect(Promotion::where('id_article', $p_id_article)->where('id_magasin', $p_id_magasin)->where('active', true)->get());
        $now = new Carbon();

        if (!$promo->isEmpty()) {
            $d = Carbon::parse($promo->first()->date_debut);
            $f = Carbon::parse($promo->first()->date_fin);
            if ($now->greaterThanOrEqualTo($d) && $now->lessThanOrEqualTo($f)) {
                return true;
            }else return false;
        } else {
            return false;
        }
    }
}

// retoruner le taux de la promotion
if (!function_exists('getPromo')) {
    function getTauxPromo($p_id_article)
    {
        if(hasPromotion($p_id_article))
        {
            $p_id_magasin = Session::get('id_magasin');
            return $promo = collect(Promotion::where('id_article', $p_id_article)->where('id_magasin', $p_id_magasin)->where('active', true)->get())->first()->taux;
        }
        else return 0;

    }
}

if(!function_exists('getNextID'))
{
    function getNextID($p_table)
    {
        switch($p_table)
        {
            case 'remises':         $lastRecord = DB::table('remises')->orderBy('id_remise', 'desc')->first();              $result = ( $lastRecord==null ? 1 : $lastRecord->id_remise + 1 ); break;
            case 'transactions':    $lastRecord = DB::table('transactions')->orderBy('id_transaction', 'desc')->first();    $result = ( $lastRecord==null ? 1 : $lastRecord->id_transaction + 1 ); break;
            case 'paiements':       $lastRecord = DB::table('paiements')->orderBy('id_paiement', 'desc')->first();          $result = ( $lastRecord==null ? 1 : $lastRecord->id_paiement + 1 ); break;
            default: return "erreur";
        }
        //$lastRecord = DB::table($table)->orderBy('id_remise', 'desc')->first(); $result = ( $lastRecord==null ? 1 : $lastRecord->id_remise + 1 );
        //if ($lastRecord == null) return 1; else return $lastRecord->id_remise + 1;

        return $result;

        //****************************************
    }
}