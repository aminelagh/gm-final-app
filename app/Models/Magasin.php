<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magasin extends Model
{
    protected $table = 'magasins';
    protected $primaryKey = 'id_magasin';

    protected $fillable = [
        'id_magasin', 'libelle',
        'ville', 'agent', 'telephone',
        'email', 'adresse',
        'deleted',
    ];

    public static function getNextID()
    {
        $lastRecord = DB::table('magasins')->orderBy('id_magasin', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_magasin + 1);
        return $result;
    }

    public static function getLibelle($p_id)
    {
        $data = self::find($p_id);
        if ($data != null)
            return $data->libelle;
        else return null;
    }

    public static function getVille($p_id)
    {
        $data = self::find($p_id);
        if ($data != null)
            return $data->ville;
        else return null;
    }

    public static function Exists($libelle)
    {
        $data = self::where('libelle', $libelle)->get()->first();
        if ($data == null)
            return false;
        else return true;
    }

    public static function ExistForUpdate($p_id, $libelle)
    {
        $x = self::where('libelle', $libelle)->where('id_magasin', '!=', $p_id)->first();
        if ($x == null)
            return false;
        else
            return true;
    }

}
