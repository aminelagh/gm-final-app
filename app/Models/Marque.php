<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Marque extends Model
{
    protected $table = 'marques';
    protected $primaryKey = 'id_marque';

    protected $fillable = [
        'id_marque', 'libelle',
        'deleted', 'image',
    ];

    static function getNextID()
    {
        $lastRecord = DB::table('marques')->orderBy('id_marque', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_marque + 1);
        return $result;
    }

    public static function Exists($libelle)
    {
        $data = self::where('libelle', $libelle)->get()->first();
        if ($data == null)
            return false;
        else return true;
    }

    public static function getLibelle($p_id)
    {
        $data = self::where('id_marque', $p_id)->get()->first();
        if ($data != null)
            return $data->libelle;
        else return null;

    }

    public static function ExistForUpdate($p_id, $libelle)
    {
        $x = self::where('libelle', $libelle)->where('id_marque', '!=', $p_id)->first();
        if ($x == null)
            return false;
        else
            return true;
    }
}
