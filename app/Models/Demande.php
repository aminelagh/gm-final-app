<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $table = 'demandes';
    protected $primaryKey = 'id_demande';

    protected $fillable = [
        'id_demande', 'id_user', 'id_magasin',
        'id_client', 'date',
    ];

    public static function getNextID()
    {
        $lastRecord = DB::table('demandes')->orderBy('id_demande', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_demande + 1);
        return $result;
    }
}
