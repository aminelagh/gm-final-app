<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id_categorie';

    protected $fillable = ['libelle', 'deleted',];

    public static function Exists($libelle)
    {
        $data = self::where('libelle', $libelle)->get()->first();
        if ($data == null)
            return false;
        else return true;
    }

    public static function getLibelle($p_id)
    {
        $data = self::where('id_categorie', $p_id)->get()->first();
        if ($data != null)
            return $data->libelle;
        else return null;
    }

    public static function ExistForUpdate($p_id, $libelle)
    {
        $x = self::where('libelle', $libelle)->where('id_categorie', '!=', $p_id)->first();
        if ($x == null)
            return false;
        else
            return true;
    }

}
