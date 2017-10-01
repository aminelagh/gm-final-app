<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agents';
    protected $primaryKey = 'id_agent';

    protected $fillable = [
        'id_agent', 'id_fournisseur',
        'nom', 'prenom','role',
        'email', 'telephone',
        'deleted',
    ];


    public static function getAgents($p_id_fournisseur)
    {
        return self::where('id_fournisseur',$p_id_fournisseur)->where('deleted',false)->get();
    }
}
