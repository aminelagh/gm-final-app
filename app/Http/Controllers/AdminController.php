<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Magasin;
use App\Models\Marque;
use App\Models\Promotion;
use App\Models\Role;
use App\Models\Stock;
use App\Models\Stock_taille;
use App\Models\Taille_article;
use App\Models\Transaction;
use App\Models\Trans_article;
use App\Models\Type_transaction;
use App\Models\User;
use App\Models\Vente;
use App\Models\Vente_article;
use Exception;
use Hash;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Session;
use Notification;

class AdminController extends Controller
{
    public function home()
    {
        return view('Espace_Admin.dashboard')->withAlertInfo("Bienvenue dans votre espace Admin")->withAlignInfo("center")->withTimerInfo(2000);
    }

    /********************************************************
     * afficher et modifier le profile et mot de passe de l admin
     **********************************************************/
    //Profile -----------------------------------------------------
    public function profile()
    {
        $data = User::where('id', Session::get('id_user'))->get()->first();
        //dump($data);
        return view('Espace_Admin.profile')->with('data', $data);
    }

    public function updatePassword()
    {
        $data = User::where('id', Session::get('id_user'))->get()->first();
        //dump($data);
        return view('Espace_Admin.profile-password')->with('data', $data);
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
            return redirect()->route('admin.profile')->with('alert_success', "Modification de votre Profile reussi.");
            //$user = User::where('id', Session::get('id_user'))->get()->first();
            //Notification::send(User::first(), new \App\Notifications\UpdateProfileNotification($user));

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

        return redirect()->route('admin.profile')->with('alert_success', "Modification du mot de passe reussi.");

    }
    //--------------------------------------------------------------

    //Users---------------------------------------------------------
    public function addUser()
    {
        $magasins = Magasin::all();
        $roles = Role::all();
        return view('Espace_Admin.add-user-form')->with(['magasins' => $magasins, 'roles' => $roles]);
    }

    public function submitAddUser()
    {
        $email = request()->get('email');
        $password = request()->get('password');
        $nom = request()->get('nom');
        $prenom = request()->get('prenom');
        $ville = request()->get('ville');
        $telephone = request()->get('telephone');
        $id_magasin = request()->get('id_magasin');
        $role_name = request()->get('role_name');

        if (User::EmailExist($email))
            return redirect()->back()->withInput(request()->except(['password']))->with('alert_warning', "L'email: <b>" . $email . "</b> existe deja.");

        $role_name = request()->get('role_name');
        $role = Sentinel::findRoleByName($role_name);

        //$user_id = request()->get('id_user');
        //$item = User::find($user_id);

        //role admin
        if ($role->id == 1) {
            $id_magasin = null;
        } //role magas
        elseif ($role->id == 2) {
            $id_magasin = 1;
            if (request()->get('id_magasin') != 1)
                redirect()->back()->withAlertWarning("Pour le role magasinier, le magasin est <b>" . Magasin::getLibelle(1) . "</b>.");

        } //role vend
        elseif ($role->id == 3) {
            if ($id_magasin == 0)
                return redirect()->back()->withInput()->withAlertWarning("Pour le role vendeur, veuillez choisir un magasin.");
            if ($id_magasin == 1)
                return redirect()->back()->withInput()->withAlertWarning("Pour le role vendeur, le magasin ne peut pas etre " . Magasin::getLibelle(1) . ".");
        }


        $credentials = [
            'email' => $email,
            'password' => $password,
            'nom' => $nom,
            'prenom' => $prenom,
            'ville' => $ville,
            'telephone' => $telephone,
            'id_magasin' => $id_magasin,
            'deleted' => false,
        ];
        try {

            $user = Sentinel::registerAndActivate($credentials);
            $role = Sentinel::findRoleByName($role_name);
            $role->users()->attach($user);

        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de creation de l'utilisateur.<br>Meessage d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        //$user1 = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\AddUserNotification($user1));
        return redirect()->back()->withAlertSuccess("Creation de l'utilisateur <b>" . $nom . " " . $prenom . "</b> reussi.");


    }

    public function users()
    {
        //$data = User::where('id', '!=', Session::get('id_user'))->whereDeleted(false)->orWhere('deleted', null)->get();
        $data = collect(DB::select("
            SELECT u.*, m.libelle, r.name
            from users u JOIN magasins m on m.id_magasin=u.id_magasin
			left JOIN role_users ru on ru.user_id=u.id
            left JOIN roles r on ru.role_id=r.id
            WHERE u.id!=1;"));
        //dd($data);
        return view('Espace_Admin.liste-users')->with('data', $data);
    }

    public function user($p_id)
    {
        if (Session::get('id_user') == $p_id)
            return redirect()->back();

        $data = User::where('id', $p_id)->first();
        if ($data == null)
            return redirect()->back()->withInput()->withAlertWarning("L'utilisateur choisi n'existe pas.");
        $roles = Role::all();
        $magasins = Magasin::all();
        if ($data == null)
            return redirect()->back()->with('alert_warning', "L'utilisateur choisi n'existe pas.");

        return view('Espace_Admin.info-user')->withData($data)->withMagasins($magasins)->withRoles($roles);
    }

    public function submitUpdateUser()
    {
        if (User::EmailExistForUpdateUser(request()->get('email'), request()->get('id_user')))
            return redirect()->back()->withInput()->withAlertDanger("L'email: <b>" . request()->get('email') . "</b> est deja utilisé pour un autre utilisateur.");

        $role_name = request()->get('role_name');
        $id_magasin = request()->get('id_magasin');
        $role = Sentinel::findRoleByName($role_name);

        $user_id = request()->get('id_user');
        $item = User::find($user_id);

        //role admin
        if ($role->id == 1) {
            $id_magasin = null;
        } //role magas
        elseif ($role->id == 2) {
            $id_magasin = 1;
            if (request()->get('id_magasin') != 1)
                redirect()->back()->withAlertWarning("Pour le role magasinier, le magasin est <b>" . Magasin::getLibelle(1) . "</b>.");

        } //role vend
        elseif ($role->id == 3) {
            if ($id_magasin == 0)
                return redirect()->back()->withInput()->withAlertWarning("Pour le role vendeur, veuillez choisir un magasin.");
            if ($id_magasin == 1)
                return redirect()->back()->withInput()->withAlertWarning("Pour le role vendeur, le magasin ne peut pas etre " . Magasin::getLibelle(1) . ".");
        }

        $password = request()->get('password');
        if (strlen($password) > 0) {
            if (strlen($password) < 8)
                return redirect()->back()->withInput()->withAlertWarning("le mot de passe doit contenir au moins 7 caractères.");
            else
                $password = Hash::make(request()->get('password'));
        }

        try {
            if (strlen($password) > 0) {
                $item->update([
                    'nom' => request()->get('nom'),
                    'prenom' => request()->get('prenom'),
                    'ville' => request()->get('ville'),
                    'telephone' => request()->get('telephone'),
                    'email' => request()->get('email'),
                    'id_magasin' => $id_magasin,
                    'password' => $password
                ]);
                redirect()->back()->withAlertInfo("Modification du mode passe effectuée");
            } else
                $item->update([
                    'nom' => request()->get('nom'),
                    'prenom' => request()->get('prenom'),
                    'ville' => request()->get('ville'),
                    'telephone' => request()->get('telephone'),
                    'email' => request()->get('email'),
                    'id_magasin' => $id_magasin
                ]);

            DB::select("update role_users set role_id=" . $role->id . " where user_id=" . $user_id . " ");

        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de Modification de l'utilisateur. <br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\UpdateUserNotification($user));
        return redirect()->back()->withAlertSuccess("Modification de l'utilisateur reussie.");


    }

    /*public function updateUserPassword($p_id)
    {
        if (Session::get('id_user') == $p_id)
            return redirect()->back();

        $data = User::where('id', $p_id)->first();
        $magasins = Magasin::all();
        if ($data == null)
            return redirect()->back()->with('alert_warning', "L'utilisateur choisi n'existe pas.");

        return view('Espace_Admin.updatePassword-user-form')->withData($data);
    }

    public function submitUpdateUserPassword()
    {
        if (strlen(request()->get('password')) < 8)
            return redirect()->back()->withInput()->with('alert_danger', "Le mot de passe doit contenir, au moins, 7 caractères.");

        $id_user = request()->get('id_user');

        $item = User::find($id_user);
        try {
            $item->update([
                'password' => Hash::make(request()->get('password'))
            ]);

        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de Modification du mot de passe.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->route('admin.user', ['p_id' => $id_user])->with('alert_success', "Modification du mot de passe reussi.");
    }*/
    //---------------------------------------------------------------

    //Articles ------------------------------------------------------
    public function articles()
    {
        $data = Article::whereDeleted(false)->get();

        $data = collect(DB::select("select *,f.libelle as libelle_f,m.libelle as libelle_m,c.libelle as libelle_c from articles a,fournisseurs f,categories c,marques m WHERE a.deleted=false AND a.id_categorie=c.id_categorie AND a.id_marque=m.id_marque AND a.id_fournisseur=f.id_fournisseur"));
        //dump($data);
        return view('Espace_Admin.liste-articles')->withData($data);
    }

    public function articles_nv()
    {
        $data = Article::nonValideArticles();
        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertInfo("Aucun nouvel article a valider");

        return view('Espace_Admin.liste-articles_nv')->withData($data);//->withAlertInfo("c")->withAlignInfo("right");
    }

    public function article($id_article)
    {
        $data = Article::find($id_article);
        if ($data == null)
            return redirect()->back()->withInput()->with('alert_warning', "L'article choisi n'existe pas.");

        $marques = Marque::all();
        $fournisseurs = Fournisseur::all();
        $categories = Categorie::all();
        return view('Espace_Admin.info-article')->withData($data)->withMarques($marques)->withFournisseurs($fournisseurs)->withCategories($categories);
    }

    public function submitUpdateArticle()
    {
        $id_article = request()->get('id_article');
        $code = request()->get('code');

        if (Article::CodeExistForUpdate($id_article, $code))
            return redirect()->back()->withInput()->with('alert_warning', "Le code: <b>" . $code . "</b> est deja utilisé pour un autre article.");

        else {
            $item = Article::find($id_article);
            try {
                $item->update([
                    'id_categorie' => request()->get('id_categorie'),
                    'id_marque' => request()->get('id_marque'),
                    'id_fournisseur' => request()->get('id_fournisseur'),

                    'code' => request()->get('code'),
                    'ref' => request()->get('ref'),
                    'alias' => request()->get('alias'),

                    'designation' => request()->get('designation'),

                    'couleur' => request()->get('couleur'),
                    'sexe' => request()->get('sexe'),

                    'prix_a' => request()->get('prix_a'),
                    'prix_v' => request()->get('prix_v'),

                    'valide' => true,
                    'deleted' => false,
                ]);

            } catch (Exception $e) {
                return redirect()->back()->withInput()->withAlertDanger("Erreur de Modification de l'article. <br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
            }
            //$user = User::where('id', Session::get('id_user'))->get()->first();
            //Notification::send(User::first(), new \App\Notifications\UpdateArticleNotification($user));

            return redirect()->route('admin.articles_nv')->with('alert_success', "Modification de l'utilisateur reussi.");

        }
    }

    public function submitArticlesValide()
    {
        //array des element du formulaire ******************
        $valide = request()->get('valide');
        $id_article = request()->get('id_article');
        //**************************************************

        if ($valide == null)
            return redirect()->back()->withInput()->with('alert_info', "Veuillez cocher les articles valides.");

        $nbreArticles = 0;

        //Boucle pour traiter chaque article ***************
        for ($i = 1; $i <= count($id_article); $i++) {
            if (isset($valide[$i])) {
                if ($valide[$i] == $i) {
                    $item = Article::find($id_article[$i]);
                    try {
                        $nbreArticles++;
                        $item->update([
                            'valide' => true,
                        ]);

                    } catch (Exception $e) {
                        return redirect()->back()->withInput()->with('alert_danger', "Erreur de validation des articles.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
                    }
                }
            }
        }
        $user = User::where('id', Session::get('id_user'))->get()->first();
        if ($nbreArticles == 1) {

            //Notification::send(User::first(), new \App\Notifications\ArticleValideNotification($user));
            return redirect()->back()->with('alert_success', "Modification reussie de $nbreArticles artticle.");

        } else if ($nbreArticles > 1) {
            //Notification::send(User::first(), new \App\Notifications\ArticleValideNotification($user));
            return redirect()->back()->with('alert_success', "Modification reussie de $nbreArticles articles.");
        } else return redirect()->back()->withInput();
    }

    /*public function article_nv($p_id)
    {
        $data = Article::where('id_article', $p_id)->where('valide', false)->get()->first();

        if ($data == null)
            return redirect()->back()->with('alert_warning', "L'article choisi n'existe pas ou il a déjà été validé.");

        $marques = Marque::all();
        $fournisseurs = Fournisseur::all();
        $categories = Categorie::all();


        return view('Espace_Admin.info-article')->withData($data)->withMarques($marques)->withFournisseurs($fournisseurs)->withCategories($categories);
    }*/

    //---------------------------------------------------------------

    public function promotions()
    {
        //$data = Promotion::where('deleted', false)->get();
        //$data = \DB::table('promotions')->where('deleted', false)->orderBy('id_magasin', 'desc')->get();
        /*$data = collect(DB::select("
          SELECT 	p.*,a.*,m.libelle,m.ville,marques.libelle as libelle_m,fournisseurs.libelle as libelle_f,categories.libelle as libelle_c
          FROM promotions p, articles a, magasins m,fournisseurs,marques,categories
          WHERE p.id_article=a.id_article AND m.id_magasin=p.id_magasin AND fournisseurs.id_fournisseur=a.id_fournisseur AND marques.id_marque=a.id_marque AND categories.id_categorie=a.id_categorie AND p.deleted=false; "));
*/

        $data = collect(DB::select("
          SELECT p.*,a.*,m.libelle,m.ville,marques.libelle as libelle_m,fournisseurs.libelle as libelle_f,categories.libelle as libelle_c
          FROM promotions p LEFT JOIN articles a ON p.id_article=a.id_article, magasins m,fournisseurs,marques,categories
          WHERE m.id_magasin=p.id_magasin AND fournisseurs.id_fournisseur=a.id_fournisseur AND marques.id_marque=a.id_marque AND categories.id_categorie=a.id_categorie AND p.deleted=false;
          "));

        return view('Espace_Admin.liste-promotions')->withData($data);
    }

    public function promotion($id_promotion)
    {
        $data = Promotion::find($id_promotion);
        if ($data == null)
            return redirect()->back()->withAlertWarning("La promotion choisie n'existe pas.");

        $magasins = Magasin::all();
        return view('Espace_Admin.info-promotion')->withData($data)->withMagasins($magasins);
    }

    public function magasins()
    {
        $data = Magasin::where('deleted', false)->get();
        //$data = \DB::table('magasins')->where('deleted', false);
        return view('Espace_Admin.liste-magasins')->withData($data);
    }

    public function magasin($id_magasin)
    {
        $data = Magasin::find($id_magasin);
        if ($data == null)
            return redirect()->back()->withAlertWarning("Le magasin choisi n'existe pas.");

        return view('Espace_Admin.info-magasin')->withData($data);
    }

    public function stocks($p_id)
    {
        $data = Stock::where('id_magasin', $p_id)->get();

        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock de ce magasin est vide.");

        $magasin = Magasin::find($p_id);
        $tailles = Taille_article::all();

        return view('Espace_Admin.liste-stocks')->withData($data)->withMagasin($magasin)->withTailles($tailles);
    }

    public function stock($id_stock)
    {
        $stock = Stock::find($id_stock);

        if ($stock == null)
            return redirect()->back()->withAlertWarning("L'element du stock choisi n'existe pas.");
        $article = Article::find($stock->id_article);
        if (Stock_taille::hasTailles($id_stock))
            $data = Stock_taille::where('id_stock', $id_stock)->get();
        else
            return redirect()->back()->withInput()->withAlertWarning("l'article choisi n'est pas disponible.");

        $magasin = Magasin::find($stock->id_magasin);

        return view('Espace_Admin.info-stock')->withData($data)->withMagasin($magasin)->withStock($stock)->withArticle($article);
    }

    public function entrees()
    {
        //$data = collect(DB::select("select * from transactions where id_type_transaction=1 order by id_transaction desc"));
        /*$data = collect(DB::select("
         select t.id_transaction,t.id_magasin,t.id_user,t.date,m.libelle,u.nom,u.prenom
         FROM transactions t,users u,magasins m
         WHERE id_type_transaction=1 AND t.id_user=u.id AND t.id_magasin=m.id_magasin AND t.annulee=false
         ORDER BY id_transaction desc
         "));*/

        $data = collect(DB::select("
         select t.*,m.libelle,u.nom,u.prenom
         FROM transactions t LEFT JOIN users u ON t.id_user=u.id JOIN magasins m ON t.id_magasin=m.id_magasin
         WHERE id_type_transaction=1 AND t.annulee=false
         ORDER BY id_transaction desc
         "));

        return view('Espace_Admin.liste-entrees')->withData($data);
    }

    public function entree($p_id)
    {
        $data = Trans_article::where('id_transaction', $p_id)->get();
        $transaction = Transaction::find($p_id);

        if ($transaction == null)
            return redirect()->back()->withAlertWarning("L'entree de stock choisie n'existe pas.");

        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Aucun article");

        return view('Espace_Admin.info-entree')->withData($data)->withTransaction($transaction);
    }

    public function sorties()
    {
        $data = collect(DB::select("
         select t.*,m.libelle,u.nom,u.prenom
         FROM transactions t LEFT JOIN users u ON t.id_user=u.id JOIN magasins m ON t.id_magasin=m.id_magasin
         WHERE id_type_transaction=2 AND t.annulee=false
         ORDER BY id_transaction desc
         "));
        return view('Espace_Admin.liste-sorties')->withData($data);
    }

    public function sortie($p_id)
    {
        $data = Trans_article::where('id_transaction', $p_id)->get();
        $transaction = Transaction::find($p_id);

        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Aucun article");

        return view('Espace_Admin.info-sortie')->withData($data)->withTransaction($transaction);
    }

    public function transfertINs()
    {
        //$data = collect(DB::select("select * from transactions where id_type_transaction=3 order by id_transaction desc"));
        $data = collect(DB::select("
         select t.*,m.libelle,u.nom,u.prenom
         FROM transactions t LEFT JOIN users u ON t.id_user=u.id JOIN magasins m ON t.id_magasin=m.id_magasin
         WHERE id_type_transaction=3 AND t.annulee=false
         ORDER BY id_transaction desc
         "));

        return view('Espace_Admin.liste-transfertINs')->withData($data);
    }

    public function transfertIN($p_id)
    {
        $data = Trans_article::where('id_transaction', $p_id)->get();
        $transaction = Transaction::find($p_id);

        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Aucun article");

        return view('Espace_Admin.info-transfertIN')->withData($data)->withTransaction($transaction);
    }

    public function transfertOUTs()
    {
        $data = collect(DB::select("
         select t.*,m.libelle,u.nom,u.prenom
         FROM transactions t LEFT JOIN users u ON t.id_user=u.id JOIN magasins m ON t.id_magasin=m.id_magasin
         WHERE id_type_transaction=4 AND t.annulee=false
         ORDER BY id_transaction desc
         "));
        return view('Espace_Admin.liste-transfertOUTs')->withData($data);
    }

    public function transfertOUT($p_id)
    {
        $data = Trans_article::where('id_transaction', $p_id)->get();
        $transaction = Transaction::find($p_id);

        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Aucun article");

        return view('Espace_Admin.info-transfertOUT')->withData($data)->withTransaction($transaction);
    }

    public function ventes()
    {
        $data = collect(DB::select("
            SELECT v.*,u.nom,u.prenom,m.libelle
            from ventes v LEFT JOIN magasins m on v.id_magasin=m.id_magasin LEFT JOIN users u on v.id_user=u.id
            ORDER BY id_vente desc
         "));

        return view('Espace_Admin.liste-ventes')->withData($data);
    }

    public function vente($p_id)
    {
        $data = Vente_article::where('id_vente', $p_id)->get();
        $vente = Vente::find($p_id);

        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Aucun article");

        return view('Espace_Admin.info-vente')->withData($data)->withVente($vente);
    }

}
