<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Paiement extends Model
{
    protected $table = 'paiements';
    protected $primaryKey = 'id_paiement';

    protected $fillable = [
      'id_paiement', '$id_mode_paiement', 'ref',
    ];

    public static function getMode_Paiement($p_id)
       {
           $data = self::where('id_paiement', $p_id)->get()->first();
           if ($data != null)
               return Mode_paiement::getLibelle($data->id_mode_paiement);
           else return null;
       }

    public static function creer($id_paiement, $id_mode_paiement, $ref)
    {
        try{
            $item = new Paiement();
            $item->id_paiement = $id_paiement;
            $item->id_mode_paiement = $id_mode_paiement;
            $item->ref = $ref;
            $item->save();

        }catch(Exception $e){return $e->getMessage();}
    }


    public static function getNextID()
    {
        $lastRecord = DB::table('paiements')->orderBy('id_paiement', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_paiement + 1);
        return $result;
    }
}
