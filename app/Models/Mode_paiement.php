<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mode_paiement extends Model
{
    protected $table = 'mode_paiements';
    protected $primaryKey = 'id_mode_paiement';

    protected $fillable = [
      'id_mode_paiement', 'libelle',
    ];

    
    public static function getLibelle($p_id)
        {
            $data = self::where('id_mode_paiement', $p_id)->get()->first();
            if ($data != null)
                return $data->libelle;
            else return null;
        }

}
