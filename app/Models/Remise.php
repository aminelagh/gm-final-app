<?php

namespace App\Models;

use \Exception;
use Illuminate\Database\Eloquent\Model;
use DB;

class Remise extends Model
{
    protected $table = 'remises';
    protected $primaryKey = 'id_remise';


    protected $fillable = [
        'id_remise', 'taux', 'raison',
    ];

    /*public function __construct($id_remise, $taux, $raison)
    {
        parent::__construct($attributes);
    }*/

    public static function creer($id_remise, $taux, $raison)
    {
        try {
            $item = new Remise();
            $item->id_remise = $id_remise;
            $item->taux = $taux;
            $item->raison = $raison;
            $item->save();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getNextID()
    {
        $lastRecord = DB::table('remises')->orderBy('id_remise', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_remise + 1);
        return $result;
    }
}
