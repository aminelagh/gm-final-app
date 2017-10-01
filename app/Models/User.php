<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Session;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_magasin', 'telephone', 'description',
        'nom', 'prenom', 'ville', 'email', 'password',
        'deleted', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function EmailExist($email)
    {
        $x = self::where('email', $email)->first();
        if ($x != null)
            return true;
        else return false;
    }

    public static function EmailExistForUpdate($email)
    {
        $x = self::where('email', $email)->first();
        if ($x == null || $x->id == Session::get('id_user'))
            return false;
        else
            return true;
    }

    public static function EmailExistForUpdateUser($email, $id_user)
    {
        $x = User::where('email', $email)->first();
        if ($x == null || $x->id == $id_user)
            return false;
        else
            return true;
    }

    public static function updateSession($p_id)
    {
        $user = self::where('id', $p_id)->first();

        Session::put('nom', $user->nom);
        Session::put('role', $user->nom);
        Session::put('prenom', $user->prenom);
        Session::put('email', $user->email);
        Session::put('id_magasin', $user->id_magasin);
    }

    public static function getRole($user_id)
    {
        $role_id = \App\Models\Role_user::where('user_id', $user_id)->first()->role_id;
        $role = \App\Models\Role::where('id', $role_id)->first()->name;
        return $role;
    }

    public static function getMagasin($id)
    {
        $data = Magasin::where('id_magasin', $id)->get();
        if ($data->isEmpty())
            return null;
        else return $data->first()->libelle;
    }

    public static function getNomUser($p_id)
    {
        $data = User::find($p_id);
        if ($data != null)
            return $data->nom;
        else return null;
    }

    public static function getPrenomUser($p_id)
    {
        $data = User::find($p_id);
        if ($data != null)
            return $data->prenom;
        else return null;
    }
}
