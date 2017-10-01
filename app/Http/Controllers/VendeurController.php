<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use PDF;
use Notification;
use App\Models\User;
use App\Models\Role;
use App\Models\Magasin;
use App\Models\Vente;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\Marque;
use App\Models\Stock;
use App\Models\Stock_taille;
use App\Models\Transaction;
use App\Models\Trans_Article;
use App\Models\Type_transaction;
use App\Models\Mode_paiement;
use App\Models\Promotion;
use App\Models\Remise;
use App\Models\Paiement;
use App\Models\Client;
use App\Models\Taille_article;
use App\Models\Vente_article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use \Exception;

class VendeurController extends Controller
{
    public function home()
    {
        return view('Espace_Vend.dashboard')->withAlertInfo("Bienvenue dans votre espace vendeur")->withAlignInfo("center")->withTimerInfo(2000);
    }

    public function profile()
    {
        $data = User::where('id', Session::get('id_user'))->get()->first();
        //dump($data);
        return view('Espace_Vend.profile')->with('data', $data);
    }

//Lister les promotions
    public function promotions()
    {
        $data = Promotion::where('deleted', false)->where('id_magasin', Session::get('id_magasin'))->get();

        return view('Espace_Vend.liste-promotions')->withData($data);
    }

    public function promotion($p_id)
    {
        $data = Promotion::find($p_id);
        $marques = Marque::all();
        $fournisseurs = Fournisseur::all();
        $categories = Categorie::all();

        if ($data == null)
            return redirect()->back()->with('alert_warning', "L'article choisi n'existe pas.");

        return view('Espace_Magas.info-article')->withData($data)->withMarques($marques)->withFournisseurs($fournisseurs)->withCategories($categories);
    }

//Lister les ventes
    // public function ventes()
    // {
    //     $data = Vente::where('deleted', false)->where('id_magasin', Session::get('id_magasin'))->get();
    //     return view('Espace_Vend.liste-promotions')->withData($data);
    // }


    public function ventes()
    {
        $id_magasin = Session::get('id_magasin');
        $data = Vente::where('id_magasin', $id_magasin)->get();
        return view('Espace_Vend.liste-ventes')->withData($data);
    }

    public function vente($id_vente)
    {
        $data = Vente_article::where('id_vente', $id_vente)->get();


        return view('Espace_Vend.info-vente')->withData($data);//->withMagasin($magasin);
    }

    //Vente simple vendeur
    public function addVenteSimpleV()
    {
        $id_magasin = Session::get('id_magasin');
        $data = Stock::where('id_magasin', $id_magasin)->get();

        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock du magasin est vide, veuillez commencer par l'alimenter.");
        $magasin = Magasin::find($id_magasin);
        $modes = Mode_paiement::all();
        $clients = Client::where('id_magasin', $id_magasin)->get();
        return view('Espace_Vend.add-vente_simple-form')->withData($data)->withMagasin($magasin)->withModesPaiement($modes)->withClients($clients);
    }

    //Vente gros vendeur
    public function addVenteGrosV()
    {
        $id_magasin = Session::get('id_magasin');
        $data = Stock::where('id_magasin', $id_magasin)->get();

        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock du magasin est vide, veuillez commencer par l'alimenter.");
        $magasin = Magasin::find(1);
        $modes = Mode_paiement::all();
        $clients = Client::where('id_magasin', 1)->get();
        return view('Espace_Vend.add-vente_gros-form')->withData($data)->withMagasin($magasin)->withModesPaiement($modes)->withClients($clients);
    }

    public function submitAddVente()
    {
        //return public_path();
        //return PDF::loadFile(public_path().'/myfile.html')->save('/path-to/my_stored_file.pdf')->stream('download.pdf');
        //dump(request()->all());
        //return 'a';

        //variables du formulaires -------------------------------------------------------------------------------------
        $id_magasin = request()->get('id_magasin');
        $id_stocks = request()->get('id_stock');
        $quantiteOUTs = request()->get('quantiteOUT');
        $id_taille_articles = request()->get('id_taille_article');
        $type_vente = request()->get('type_vente');
        $id_client = request()->get('id_client');

        //paiement:
        $id_mode_paiement = request()->get('id_mode_paiement');
        $ref = request()->get('ref');

        //remise:
        $taux_remise = request()->get('taux_remise');
        $raison = request()->get('raison');

        //montants
        $total_sans_remise = request()->get('total_prix');
        $total_avec_remise = request()->get('montant');
        //--------------------------------------------------------------------------------------------------------------

        //dump("taux remise: " . $taux_remise);
        //dump("raison: " . $raison);

        //verifier la validitee des donnees ----------------------------------------------------------------------------
        $hasData = false;
        foreach ($id_stocks as $id_stock) {
            if (isset($quantiteOUTs[$id_stock])) {
                $i = 1;
                foreach ($quantiteOUTs[$id_stock] as $quantiteOUT) {
                    if ($quantiteOUT != null && $quantiteOUT > 0) {
                        $hasData = true;
                    }
                    $i++;
                }
            }
        }
        if (!$hasData)
            return redirect()->back()->withInput()->withAlertInfo("Remplissez les formulaires.");
        //--------------------------------------------------------------------------------------------------------------

        //Creation d'une vente -----------------------------------------------------------------------------------------
        $id_vente = Vente::getNextID();
        if ($taux_remise > 0) {
            if (strlen($raison) <= 0)
                return redirect()->back()->withInput()->withAlertWarning("Veuillez spécifier la raison de la remise.");
            else
                Vente::createVenteRemise($id_vente, $id_mode_paiement, $ref, $id_client, $taux_remise, $raison);
        } else
            Vente::createVente($id_vente, $id_mode_paiement, $ref, $id_client);
        //--------------------------------------------------------------------------------------------------------------

        //Creation des trans_articles ----------------------------------------------------------------------------------
        foreach ($id_stocks as $id_stock) {
            if (isset($quantiteOUTs[$id_stock])) {
                $stock = Stock::find($id_stock);
                $i = 1;
                foreach ($quantiteOUTs[$id_stock] as $quantite) {
                    if ($quantite != null && $quantite != 0) {
                        $id_taille_article = $id_taille_articles[$id_stock][$i];
                        $id_article = Stock::getIdArticle($id_stock);
                        $prix_article = 0;//Article::getPrixPromoSimple($id_article);

                        if ($type_vente = "simple")
                            $prix_article = Article::getPrixPromoSimple($id_article);
                        else $prix_article = Article::getPrixPromoGros($id_article);

                        //decrementer le stock -------------------------------------------------------------------------
                        Stock_taille::decrementer($id_stock, $id_taille_article, $quantite);
                        //----------------------------------------------------------------------------------------------
                        //Creer une nouvelle ligne dans: vente_article -------------------------------------------------
                        Vente_article::create($id_vente, $id_article, $id_taille_article, $prix_article, 0, $quantite);
                        //----------------------------------------------------------------------------------------------
                    }
                    $i++;
                }
            }
        }
        //--------------------------------------------------------------------------------------------------------------
        //return redirect()->back()->withAlertSuccess("Sortie de stock effectuée avec succès");
        //return view('Espace_Magas.add-vente_2-form')->withAlertInfo("Un nouveau panier a ete cree.");
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\AddVenteVNotification($user));
        //return $this->printfacture(5);
        return redirect()->route('magas.addVente');
    }

    public static function printfacture()
    {
        $pdf = PDF::loadView('Espace_Vend.pdf-facture');
        return $pdf->download('facture.pdf');
    }

    public function main_stocks_V()
    {
        $data = Stock::where('id_magasin', 1)->get();
        $magasin = Magasin::find(1);
        $tailles = Taille_article::all();

        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock du magasin principal est vide, vous devez le créer.")->withRouteWarning('/magas/addStock/' . 1);
        else
            return view('Espace_Vend.liste-main_stocks')->withData($data)->withMagasin($magasin)->withTailles($tailles);
    }

    public function stocks_V()
    {
        //if ($p_id == 1)
        //  return redirect()->back()->withInput()->withAlertInfo("Vous ne pouvez pas accéder à ce magasin de cette manière.");
        $id_magasin = Session::get('id_magasin');
        $data = Stock::where('id_magasin', $id_magasin)->get();
        $magasin = Magasin::find($id_magasin);
        $tailles = Taille_article::all();

        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock de ce magasin est vide, vous pouvez commencer par le créer.")->withRouteWarning('/magas/addStock/' . $p_id);
        else
            return view('Espace_Vend.liste-stocks')->withData($data)->withMagasin($magasin)->withTailles($tailles);
    }


}
