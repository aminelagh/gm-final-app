<?php

namespace App\Models;

use \Exception;
use Illuminate\Database\Eloquent\Model;
use DB;

class Taille_article extends Model
{
    protected $table = 'taille_articles';
    protected $primaryKey = 'id_taille_article';


    protected $fillable = [
        'id_taille_article', 'taille',
    ];

    public static function getTaille($p_id)
    {
        return self::find($p_id)->taille;
    }

}
