<?php

namespace App\Http\Controllers;

use \Exception;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Session;
use Sentinel;
use Illuminate\Http\Request;
use \App\Models\Role;
use \App\Models\Role_user;

class AuthController extends Controller
{
    public function login()
    {
        if (!Sentinel::check()) {
            return view('login');
        }

        if (Sentinel::inRole('admin'))
            return redirect()->route('admin.home');//->with('error', 'You are a customer and cannot access to backend section');
        else if (Sentinel::inRole('magas'))
            return redirect()->route('magas.home');
        else if (Sentinel::inRole('direct'))
            return redirect()->route('direct.home');
        else if (Sentinel::inRole('vend'))
            return redirect()->route('vend.home');
        else echo "Error Login AuthController";

    }

    public function submitLogin(Request $request)
    {
        try {

            if (request()->has('remember'))
                $user = Sentinel::authenticateAndRemember(request()->all());
            else
                $user = Sentinel::authenticate(request()->all());

            if (Sentinel::check()) {
                Session::put('id_user', $user->id);
                Session::put('role', $this->getRole());
                Session::put('id_magasin', $user->id_magasin);
                Session::put('email', $user->email);
                Session::put('nom', $user->nom);
                Session::put('prenom', $user->prenom);

                return $this->redirectToSpace();

            } else return redirect()->back()->withInput()->withAlertWarning("<b>login et/ou mot de passe incorrect</b>")->withTimerWarning(2000);

        } catch (ThrottlingException $e) {

            return redirect()->back()->withInput()->with('alert_success', "<b>Une activité suspecte s'est produite sur votre adresse IP, l'accès vous est refusé pour " . $e->getDelay() . " seconde (s)</b>")->withTimerDanger($e->getDelay() * 1000);

        }
    }

    public function logout()
    {
        Sentinel::logout(null, true);
        Session::flush();
        return redirect()->route('login');
    }

    //permet de rediriger chaque user vers son propre espace apres l authentification
    public function redirectToSpace()
    {
        if (Sentinel::inRole('admin'))
            return redirect()->route('admin.home');
        else if (Sentinel::inRole('direct'))
            return route('home');//redirect()->route('direct.home');
        else if (Sentinel::inRole('magas'))
            return redirect()->route('magas.home');
        else if (Sentinel::inRole('vend'))
            return redirect()->route('vend.home');
    }

    public function getRole()
    {
        if (Sentinel::inRole('admin'))
            return "admin";
        //else if (Sentinel::inRole('direct'))
            //return "direct";
        else if (Sentinel::inRole('magas'))
            return "magas";
        else if (Sentinel::inRole('vend'))
            return "vend";
    }
}
