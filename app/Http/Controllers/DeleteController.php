<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Notification;
use App\Models\User;
use Session;

class DeleteController extends Controller
{
    //Admin ------------------------------------------------------------------------------------------------------------
    public function adminUser($id)
    {
        try {
            DB::select("delete from users where id=" . $id . " ");
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de suppression de l'utilisateur.<br>Messagde d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\DeleteUserNotification($user));
        return redirect()->route('admin.users')->withInput()->withAlertSuccess("L'utilisateur a été effacé avec succès");
    }

    public function adminPromotion($id)
    {
        try {
            DB::select("delete from promotions where id_promotion=" . $id . " ");
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de suppression de la promotion.<br>Messagde d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\DeletePromotionNotification($user));
        return redirect()->route('admin.promotions')->withInput()->withAlertSuccess("La promotion a été effacé avec succès");
    }

    public function adminArticle($id)
    {
        try {
            DB::select("update articles set deleted=1  where id_article=" . $id . " ");
            DB::select("delete from stocks where id_article=" . $id . " ");
            DB::select("delete from stock_tailles where id_stock=(select id_stock from stocks where id_article =" . $id . ") ");
            //DB::select("delete from trans_articles where id_article=" . $id . " ");
            //DB::select("delete from vente_articles where id_article=" . $id . " ");
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de suppression de l'article.<br>Messagde d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\DeleteArticleNotification($user));
        return redirect()->route('admin.articles')->withInput()->withAlertSuccess("L'article a été effacé avec succès");
    }

    public function adminArticleNV($id)
    {
        try {

            DB::select("delete from articles where id_article=" . $id . " ");
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de suppression de l'article.<br>Messagde d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\DeleteArticleNotification($user));
        return redirect()->route('admin.articles')->withInput()->withAlertSuccess("L'article a été effacé avec succès");
    }

    public function adminMagasin($id)
    {
        try {
            DB::select("delete from magasins where id_magasin=" . $id . " ");
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de suppression du magasin.<br>Messagde d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\DeleteMagasinNotification($user));
        return redirect()->route('admin.magasins')->withInput()->withAlertSuccess("Le magasin a été effacé avec succès");
    }
    //------------------------------------------------------------------------------------------------------------------

    //Magas ------------------------------------------------------------------------------------------------------------
    public function magasMarque($id)
    {
        try {
            DB::select("delete from marques where id_marque=" . $id . " ");
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de suppression de la marque.<br>Messagde d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->route('magas.marques')->withInput()->withAlertSuccess("La marque a été effacé avec succès");
    }

    public function magasCategorie($id)
    {
        try {
            DB::select("delete from categories where id_categorie=" . $id . " ");
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de suppression de l'article.<br>Messagde d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->route('magas.categories')->withInput()->withAlertSuccess("L'article a été effacé avec succès");
    }

    public function magasMagasin($id)
    {
        try {
            DB::select("delete from magasins where id_magasin=" . $id . " ");
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de suppression du magasin.<br>Messagde d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->route('magas.magasins')->withInput()->withAlertSuccess("Le magasin a été effacé avec succès");
    }

    public function magasFournisseur($id)
    {
        try {
            DB::select("delete from fournisseurs where id_fournisseur=" . $id . " ");
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de suppression du fournisseur.<br>Messagde d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->route('magas.fournisseurs')->withInput()->withAlertSuccess("Le fournisseur a été effacé avec succès");
    }

    public function magasClient($id)
    {
        try {
            DB::select("delete from clients where id_client=" . $id . " ");
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de suppression du client.<br>Messagde d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\DeleteClientNotification($user));
        return redirect()->route('magas.clients')->withInput()->withAlertSuccess("Le Client a été effacé avec succès");
    }
    //------------------------------------------------------------------------------------------------------------------

    /******************************************
     * Fonction pour effacer une ligne d'une table
     ******************************************
     * public function delete($p_table, $p_id)
     * {
     * try {
     * switch ($p_table) {
     * case 'categories':
     * $item = Categorie::find($p_id);
     * if ($item != null) {
     * $item->update(['deleted' => true]); //$item->delete();
     *
     * return back()->withInput()->with('alert_success', "La catégorie a été effacée avec succès");
     * } else {
     * return back()->withInput()->with('alert-warning', "La catégorie choisie n'existe pas.");
     * }
     * break;
     * case 'users':
     * $item = User::find($p_id);
     * if ($item != null) {
     * $item->update(['deleted' => true]);
     * return back()->withInput()->with('alert_success', "L'utilisateur a été effacé avec succès");
     * } else {
     * return back()->withInput()->with('alert-warning', "L'utilisateur choisi n'existe pas.");
     * }
     * break;
     * case 'fournisseurs':
     * $item = Fournisseur::find($p_id);
     * if ($item != null) {
     * $item->update(['deleted' => true]);
     * return back()->withInput()->with('alert_success', "Le fournisseur a été effacé avec succès");
     * } else {
     * return back()->withInput()->with('alert-warning', "Le fournisseur choisi n'existe pas.");
     * }
     * break;
     * case 'articles':
     * $item = Article::find($p_id);
     * if ($item != null) {
     * $item->update(['deleted' => true]);
     * return back()->withInput()->with('alert_success', "L'article a été effacé avec succès");
     * } else {
     * return back()->withInput()->with('alert-warning', "L'article choisi n'existe pas.");
     * }
     * break;
     * case 'magasins':
     * $item = Magasin::find($p_id);
     * if ($item != null) {
     * $item->update(['deleted' => true]);
     *
     * return back()->withInput()->with('alert_success', "Le magasin a été effacé avec succès");
     * } else {
     * return back()->withInput()->with('alert-warning', "Le magasin choisi n'existe pas.");
     * }
     * break;
     * case 'stocks':
     * $item = Stock::find($p_id);
     * if ($item != null) {
     * $item->delete();
     * return back()->withInput()->with('alert_success', "L'element du stock a été effacé avec succès.");
     * } else {
     * return back()->withInput()->with('alert-warning', "L'element du stock choisi n'existe pas.");
     * }
     * break;
     * case 'promotions':
     * $item = Promotion::find($p_id);
     * if ($item != null) {
     * $item->update(['deleted' => true]);
     * return back()->withInput()->with('alert_success', "La promotion a été effacée avec succès.");
     * } else {
     * return back()->withInput()->with('alert-warning', "La promotion choisie n'existe pas.");
     * }
     * break;
     * case 'marques':
     * $item = Marque::find($p_id);
     * if ($item != null) {
     * $item->update(['deleted' => true]);
     * return back()->withInput()->with('alert_success', "La marque a été effacée avec succès");
     * } else {
     * return back()->withInput()->with('alert-warning', "La marque choisie n'existe pas.");
     * }
     * break;
     * case 'agents':
     * $item = Agent::find($p_id);
     * if ($item != null) {
     * $item->update(['deleted' => true]);
     * return back()->withInput()->with('alert_success', "L'agent a été effacé avec succès");
     * } else {
     * return back()->withInput()->with('alert-warning', "L'agent choisi n'existe pas.");
     * }
     * break;
     * default:
     * return back()->withInput()->with('alert_danger', "Probleme de redirection. DeleteController@delete");
     * break;
     * }
     * } catch (Exception $ex) {
     * return back()->with('alert_danger', "Erreur de suppression.<br>Message d'erreur: <b>" . $ex->getMessage() . ", code: (" . $ex->getCode() . ").</b>");
     * }
     * }*/


}
