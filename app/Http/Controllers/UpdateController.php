<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\Magasin;
use App\Models\Marque;
use App\Models\Promotion;
use App\Models\User;
use Carbon\Carbon;
use Notification;
use Session;
use Mockery\Exception;

class UpdateController extends Controller
{
    public function submitUpdateClient()
    {
        $id_client = request()->get('id_client');
        $nom = request()->get('nom');
        $prenom = request()->get('prenom');

        if (Client::ExistForUpdate($id_client, $nom, $prenom))
            return redirect()->back()->withInput()->withAlertWarning("Le client: <b>" . $nom . " " . $prenom . "</b> existe deja.");

        $sexe = request()->get('sexe');
        $age = request()->get('age');
        $ville = request()->get('ville');

        $item = Client::find($id_client);
        try {
            $item->update([
                'nom' => $nom,
                'prenom' => $prenom,
                'sexe' => $sexe,
                'age' => $age,
                'ville' => $ville,
                'deleted' => false,
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de modification.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->back()->with('alert_success', "Modification reussie du client " . $nom . " " . $prenom);
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\UpdateClientNotification($user));

    }

    public function submitUpdateMarque()
    {
        $id_marque = request()->get('id_marque');
        $libelle = request()->get('libelle');

        if (Marque::ExistForUpdate($id_marque, $libelle))
            return redirect()->back()->withInput()->with('alert_danger', "La marque: <b>" . $libelle . "</b> existe deja.");

        $item = Marque::find($id_marque);
        try {
            $item->update([
                'libelle' => $libelle,
            ]);

            if (request()->hasFile('image')) {
                $file_extension = request()->file('image')->extension();
                $file_name = "marque_" . $id_marque . "." . $file_extension;
                request()->file('image')->move("uploads/images/marques", $file_name);
                $image = "/uploads/images/marques/" . $file_name;
                $item->update(['image' => $image]);
            }
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de modification.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->back()->with('alert_success', "Modification reussie.");
    }

    public function submitUpdateCategorie()
    {
        $id_categorie = request()->get('id_categorie');
        $libelle = request()->get('libelle');

        if (Categorie::ExistForUpdate($id_categorie, $libelle))
            return redirect()->back()->withInput()->with('alert_danger', "La categorie: <b>" . $libelle . "</b> existe deja.");

        $item = Categorie::find($id_categorie);
        try {
            $item->update([
                'libelle' => $libelle,
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de modification.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->back()->with('alert_success', "Modification reussie.");
    }

    public function submitUpdateFournisseurAgents()
    {
        //Update Fournisseur:
        $id_fournisseur = request()->get('id_fournisseur');
        $libelle = request()->get('libelle');
        $code = request()->get('code');

        if (Fournisseur::CodeExistForUpdate($id_fournisseur, $code))
            return redirect()->back()->withInput()->with('alert_warning', "Le code: <b>" . $code . "</b> existe déjà.");

        if (Fournisseur::LibelleExistForUpdate($id_fournisseur, $libelle))
            return redirect()->back()->withInput()->with('alert_warning', "Le fournisseur: <b>" . $libelle . "</b> existe déjà.");

        $item = Fournisseur::find($id_fournisseur);
        try {
            $item->update(['libelle' => $libelle,
                'code' => $code,]);
        } catch
        (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de modification.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        //----------------------------------------------------

        //Update Agents:

        //array des element du formulaire
        $id_agent = request()->get('id_agent');
        $nom = request()->get('nom');
        $prenom = request()->get('prenom');
        $telephone = request()->get('telephone');
        $email = request()->get('email');
        $ville = request()->get('ville');
        $role = request()->get('role');

        //Update each agent
        for ($i = 1; $i <= count($id_agent); $i++) {
            $item = Agent::find($id_agent[$i]);
            try {
                $item->update([
                    'role' => $role[$i],
                    'nom' => $nom[$i],
                    'prenom' => $prenom[$i],
                    'email' => $email[$i],
                    'telephone' => $telephone[$i],
                    'ville' => $ville[$i],
                ]);
            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('alert_danger', "Erreur de modification.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
            }
        }
        return redirect()->back()->with('alert_success', "Modification reussie.");
    }

    public function submitUpdateArticle()
    {
        $id_article = request()->get('id_article');

        $id_categorie = request()->get('id_categorie');
        $id_fournisseur = request()->get('id_fournisseur');
        $id_marque = request()->get('id_marque');

        $code = request()->get('code');
        $ref = request()->get('ref');
        $alias = request()->get('alias');

        $designation = request()->get('designation');

        $sexe = request()->get('sexe');
        $couleur = request()->get('couleur');
        $prix_a = request()->get('prix_a');
        $prix_v = request()->get('prix_v');


        if (Article::CodeExistForUpdate($id_article, $code))
            return redirect()->back()->withInput()->with('alert_warning', "Le code: <b>" . $code . "</b> existe deja.");

        $item = Article::find($id_article);
        try {
            $item->update([
                'id_categorie' => $id_categorie,
                'id_fournisseur' => $id_fournisseur,
                'id_marque' => $id_marque,

                'code' => $code,
                'ref' => $ref,
                'alias' => $alias,

                'designation' => $designation,

                'sexe' => $sexe,
                'couleur' => $couleur,

                'prix_a' => $prix_a,
                'prix_v' => $prix_v,
                'valide' => false,
            ]);

            if (request()->hasFile('image')) {
                $file_extension = request()->file('image')->extension();
                $file_name = "marque_" . $id_marque . "." . $file_extension;
                request()->file('image')->move("uploads/images/articles", $file_name);
                $image = "/uploads/images/articles/" . $file_name;
                $item->update(['image' => $image]);
            }
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de modification.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }

        return redirect()->back()->with('alert_success', "Modification reussie.");
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\UpdateArticleNotification($user));
    }

    public function submitUpdateMagasin()
    {
        $libelle = request()->get('libelle');
        $id_magasin = request()->get('id_magasin');

        if (Magasin::ExistForUpdate($id_magasin, $libelle))
            return redirect()->back()->withInput()->with("alert_warning", "Le magasin <b>" . $libelle . "</b> existe déjà.");

        $item = Magasin::find($id_magasin);
        $item->update([
            'libelle' => request()->get('libelle'),
            'ville' => request()->get('ville'),
            'agent' => request()->get('agent'),
            'email' => request()->get('email'),
            'telephone' => request()->get('telephone'),
            'adresse' => request()->get('adresse'),
        ]);

        return redirect()->back()->withInput()->with('alert_success', 'Modification du magasin reussi.');
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\UpdateMagasinNotification($user));
    }

    public function submitUpdatePromotion()
    {
        //recuperer les variables -----------------
        $id_magasin = request()->get('id_magasin');
        $id_promotion = request()->get('id_promotion');
        $taux = request()->get('taux');
        $date_debut = request()->get('date_debut');
        $date_fin = request()->get('date_fin');
        $active = request()->get('active');
        if ($active != true)
            $active = false;
        //-----------------------------------------

        //checking data ---------------------------
        if ($taux == 0 || $taux == null || $date_debut == null || $date_fin == null)
            return redirect()->back()->withAlertInfo("Veuillez remplier les champs taux , date debut et date fin pour les articles souhaités.");
        //-----------------------------------------


        //verifier les dates et les champs -------------------------------------------------------------------------
        if ($taux == 0 || $taux == null)
            return redirect()->back()->withInput()->withAlertWarning("Veuillez remplir le champ <b>taux</b>.");

        if (!Promotion::isDate($date_debut) || !Promotion::isDate($date_fin) || $date_debut == null || $date_fin == null)
            return redirect()->back()->withInput()->withAlertWarning("Erreur de validité des dates");


        $dd = Carbon::createFromFormat('d-m-Y', date('d-m-Y', strtotime($date_debut)));
        $df = Carbon::createFromFormat('d-m-Y', date('d-m-Y', strtotime($date_fin)));

        if ($dd->year > $df->year)
            return redirect()->back()->withInput()->withAlertWarning("Erreur de validité des dates");

        if ($dd->year == $df->year)
            if ($dd->month > $df->month)
                return redirect()->back()->withInput()->withAlertWarning("Erreur de validité des dates");
            elseif ($dd->month == $df->month)
                if ($dd->day > $df->day)
                    return redirect()->back()->withInput()->withAlertWarning("Erreur de validité des dates");

        //----------------------------------------------------------------------------------------------------------

        //creer les dates pour la db -------------------------------------------------------------------------------
        $debut = $dd->year . "-" . $dd->month . "-" . $dd->day;
        $fin = $df->year . "-" . $df->month . "-" . $df->day;
        //----------------------------------------------------------------------------------------------------------

        try {
            $item = Promotion::find($id_promotion);
            $item->update([
                'id_magasin' => $id_magasin,
                'taux' => $taux,
                'date_debut' => $debut,
                'date_fin' => $fin,
                'active' => $active,
                'deleted' => false
            ]);

        } catch (Exception $e) {
            return rediret()->back()->withAlertDanger("Erreur de modification de la promotion. Message d'erreur: " . $e->getMessage() . "</li>");
        }

        //----------------------------------------------------------------------------------------------------------

        return redirect()->back()->withInput()->withAlertSuccess("Modification de la promotion reussie.");
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\UpdatePromotionNotification($user));
    }

}
