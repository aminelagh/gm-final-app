<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Mode_paiement;
use App\Models\Promotion;
use App\Models\Stock;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Magasin;
use App\Models\Marque;
use App\Models\User;
use App\Models\Stock_taille;
use Hash;
use \DB;
use Charts;
use Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Khill\Lavacharts\Lavacharts;
use Mockery\Exception;

class MagasController extends Controller
{
    public function home()
    {
        $magasins = collect(DB::select("select id_magasin,libelle from magasins where id_magasin != 1"));
        return view('Espace_Magas.dashboard')->withMagasins($magasins);
    }

    public function profile()
    {
        $data = User::where('id', Session::get('id_user'))->get()->first();
        //dump($data);
        return view('Espace_Magas.profile')->with('data', $data);
    }

    public function updatePassword()
    {
        $data = User::where('id', Session::get('id_user'))->get()->first();
        //dump($data);
        return view('Espace_Magas.profile-password')->with('data', $data);
    }

    public function submitUpdateProfile()
    {
        if (User::EmailExistForUpdate(request()->get('email')))
            return redirect()->back()->withInput()->with('alert_danger', "L'email: <b>" . request()->get('email') . "</b> est deja utilisé pour un autre utilisateur.");

        else {
            $item = User::find(request()->get('id_user'));
            try {
                $item->update([
                    'nom' => request()->get('nom'),
                    'prenom' => request()->get('prenom'),
                    'ville' => request()->get('ville'),
                    'telephone' => request()->get('telephone'),
                    'telephone' => request()->get('telephone'),
                    'email' => request()->get('email')
                ]);
                User::updateSession(request()->get('id_user'));

            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('alert_danger', "Erreur de Modification de votre profile.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
            }
            //$user = User::where('id', Session::get('id_user'))->get()->first();
            //Notification::send(User::first(), new \App\Notifications\UpdateProfileNotification($user));
            return redirect()->route('magas.profile')->with('alert_success', "Modification de votre Profile reussi.");
        }
    }

    public function submitUpdatePassword()
    {
        if (strlen(request()->get('password')) < 8)
            return redirect()->back()->withInput()->with('alert_danger', "Le mot de passe doit contenir, au moins, 7 caractères.");

        $item = User::find(request()->get('id_user'));
        try {
            $item->update([
                'password' => Hash::make(request()->get('password'))
            ]);

        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de Modification du mot de passe.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\UpdatePasswordNotification($user));
        return redirect()->route('magas.profile')->with('alert_success', "Modification du mot de passe reussi.");
    }

    /********************************************************
     * Afficher les listes
     *********************************************************/
    public function marques()
    {
        $data = Marque::where('deleted', false)->get();
        return view('Espace_Magas.liste-marques')->withData($data);
    }

    public function categories()
    {
        $data = Categorie::where('deleted', false)->get();
        return view('Espace_Magas.liste-categories')->withData($data);
    }

    public function fournisseurs()
    {
        $data = Fournisseur::where('deleted', false)->get();
        return view('Espace_Magas.liste-fournisseurs')->withData($data);
    }

    public function agents()
    {
        $data = Agent::where('deleted', false)->get();
        return view('Espace_Magas.liste-agents')->withData($data);
    }

    public function articles()
    {
        $data = Article::where('deleted', false)->get();
        $marques = Marque::all();
        $fournisseurs = Fournisseur::all();
        $categories = Categorie::all();

        return view('Espace_Magas.liste-articles')->withData($data);
    }

    public function magasins()
    {
        $data = Magasin::where('deleted', false)->where('id_magasin', '!=', 1)->get();
        return view('Espace_Magas.liste-magasins')->withData($data);
    }

    public function clients()
    {
        $data = Client::where('deleted', false)->where('id_magasin', Session::get('id_magasin'))->get();
        return view('Espace_Magas.liste-clients')->withData($data);
    }

    public function promotions()
    {
        //$data = Promotion::where('deleted', false)->where('id_magasin', Session::get('id_magasin'))->get();
        $data = collect(DB::select("
            SELECT p.*,a.*,
                  c.libelle as libelle_c, m.libelle as libelle_m, f.libelle as libelle_f,
                  mag.libelle as libelle_mag, mag.id_magasin, mag.ville
            FROM promotions p LEFT JOIN articles a on p.id_article=a.id_article
                          LEFT JOIN categories c on a.id_categorie=c.id_categorie
                          LEFT JOIN fournisseurs f on a.id_fournisseur=f.id_fournisseur
                          LEFT JOIN marques m on a.id_marque=m.id_marque
                          LEFT JOIN magasins mag on mag.id_magasin=p.id_magasin
            WHERE p.id_magasin=" . 1 . " AND p.deleted=false order by p.created_at;"));
        return view('Espace_Magas.liste-promotions')->withData($data);
    }
    /******************************************************************************************************************/

    /********************************************************
     * Afficher les infos
     *********************************************************/
    public function client($p_id)
    {
        $data = Client::find($p_id);
        if ($data == null)
            return redirect()->back()->with('alert_warning', "Le client choisi n'existe pas.");

        return view('Espace_Magas.info-client')->withData($data);
    }

    public function marque($p_id)
    {
        $data = Marque::find($p_id);
        if ($data == null)
            return redirect()->back()->with('alert_warning', "La marque choisie n'existe pas.");

        $articles = Article::where('id_marque', $p_id)->where('deleted', false)->where('valide', true)->get();
        return view('Espace_Magas.info-marque')->withData($data)->withArticles($articles);
    }

    public function categorie($p_id)
    {
        $data = Categorie::find($p_id);
        if ($data == null)
            return redirect()->back()->with('alert_warning', "La categorie choisie n'existe pas.");

        $articles = Article::where('id_categorie', $p_id)->where('deleted', false)->where('valide', true)->get();
        return view('Espace_Magas.info-categorie')->withData($data)->withArticles($articles);
    }

    public function fournisseur($p_id)
    {
        $data = Fournisseur::find($p_id);
        if ($data == null)
            return redirect()->back()->with('alert_warning', "La categorie choisie n'existe pas.");

        $articles = Article::where('id_fournisseur', $p_id)->where('deleted', false)->where('valide', true)->get();
        $agents = Agent::where('id_fournisseur', $p_id)->get();
        return view('Espace_Magas.info-fournisseur')->withData($data)->withArticles($articles)->withAgents($agents);
    }

    public function agent($p_id)
    {
        $data = Agent::find($p_id);
        if ($data == null)
            return redirect()->back()->with('alert_warning', "L'agent choisi n'existe pas.");

        return view('Espace_Magas.info-agent')->withData($data);//->withArticles($articles);
    }

    public function article($p_id)
    {
        $data = Article::find($p_id);
        $marques = Marque::all();
        $fournisseurs = Fournisseur::all();
        $categories = Categorie::all();

        if ($data == null)
            return redirect()->back()->with('alert_warning', "L'article choisi n'existe pas.");

        return view('Espace_Magas.info-article')->withData($data)->withMarques($marques)->withFournisseurs($fournisseurs)->withCategories($categories);
    }

    public function magasin($p_id)
    {
        if ($p_id == 1)
            return redirect()->back()->withInput()->with('alert_info', "Vous ne pouvez pas acceder a ce magasin de cette maniere.");

        $data = Magasin::find($p_id);
        //$stock = Stock::where('id_magasin', $p_id)->get();

        if ($data == null)
            return redirect()->back()->with('alert_warning', "Le magasin choisi n'existe pas.");

        return view('Espace_Magas.info-magasin')->withData($data);//->withStock($stock);
    }

    public function main_magasin()
    {
        $data = Magasin::find(1);
        //$stock = Stock::where('id_magasin', 1)->get();

        return view('Espace_Magas.info-main_magasin')->withData($data);//->withStock($stock);
    }


    //Ventes
    public function addVente()
    {
        //$data = Stock::where('id_magasin', 1)->get();
        $data = collect(DB::select("
            SELECT s.*,a.designation,a.code,a.ref,a.alias,a.couleur,a.sexe,a.image,
                  c.libelle as libelle_c, m.libelle as libelle_m, f.libelle as libelle_f
            FROM Stocks s LEFT JOIN articles a on s.id_article=a.id_article
                          LEFT JOIN categories c on a.id_categorie=c.id_categorie
                          LEFT JOIN fournisseurs f on a.id_fournisseur=f.id_fournisseur
                          LEFT JOIN marques m on a.id_marque=m.id_marque
            WHERE s.id_magasin=" . 1 . " order by a.id_article;"));

        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock du magasin est vide, veuillez commencer par l'alimenter.");
        $magasin = Magasin::find(1);
        $modes = Mode_paiement::all();
        $clients = Client::where('id_magasin', 1)->get();
        return view('Espace_Magas.add-vente-form')->withData($data)->withMagasin($magasin)->withModesPaiement($modes)->withClients($clients);
    }
}
