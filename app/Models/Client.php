<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id_client';

    protected $fillable = ['nom', 'prenom',
        'age', 'sexe',
        'ville', 'deleted',
    ];

    public static function Exists($nom, $prenom)
    {
        $data = self::where('nom', $nom)->where('prenom', $prenom)->get()->first();
        if ($data == null)
            return false;
        else return true;
    }

    public static function getNom($id)
    {
        $data = self::find($id);
        if ($data != null)
            return $data->nom;
        else return null;
    }

    public static function getPrenom($id)
    {
        $data = self::find($id);
        if ($data != null)
            return $data->prenom;
        else return null;
    }

    public static function ExistForUpdate($id,$nom, $prenom)
    {
        $x = self::where('nom', $nom)->where('prenom', $prenom)->where('id_client', '!=', $id)->first();
        if ($x == null)
            return false;
        else
            return true;
    }
}
