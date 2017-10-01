<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Models\Client;
use App\Models\Magasin;
use App\Models\Mode_paiement;
use App\Models\Stock;
use App\Models\Stock_taille;
use App\Models\Vente;
use App\Models\Vente_article;
use Illuminate\Support\Facades\DB;
use Notification;
use Illuminate\Support\Facades\Session;
use PDF;

class VenteController extends Controller
{
    public function ventes()
    {
        $data = Vente::all();
        return view('Espace_Magas.liste-ventes')->withData($data);
    }

    public function vente($id_vente)
    {
        $data = Vente_article::where('id_vente', $id_vente)->get();

        //  $vente1=Vente::find($data->id_vente);
        //  $magasin = Magasin::find($vente1->id_magasin);

        return view('Espace_Magas.info-vente')->withData($data);//->withMagasin($magasin);
    }

    public function addVenteSimple()
    {
        $data = Stock::where('id_magasin', 1)->get();
        //$data = collect(DB::select("select * from stocks s join articles a on s.id_article = a.id_article join stock_tailles st on st.id_stock = s.id_stock where s.id_magasin=1 order by quantite desc"));
        //$data = collect(DB::select("select * from stocks s join stock_tailles st on st.id_stock = s.id_stock where s.id_magasin=1 order by st.quantite desc"));
        //dump($data);

        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock du magasin est vide, veuillez commencer par l'alimenter.");
        $magasin = Magasin::find(1);
        $modes = Mode_paiement::all();
        $clients = Client::where('id_magasin', 1)->get();
        return view('Espace_Magas.add-vente_simple-form')->withData($data)->withMagasin($magasin)->withModesPaiement($modes)->withClients($clients);
    }

    public function addVenteGros()
    {
        $data = Stock::where('id_magasin', 1)->get();
        //$data = collect(DB::select("select * from stocks s join articles a on s.id_article = a.id_article join stock_tailles st on st.id_stock = s.id_stock where s.id_magasin=1 order by quantite desc"));
        //$data = collect(DB::select("select * from stocks s join stock_tailles st on st.id_stock = s.id_stock where s.id_magasin=1 order by st.quantite desc"));
        //dump($data);

        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock du magasin est vide, veuillez commencer par l'alimenter.");
        $magasin = Magasin::find(1);
        $modes = Mode_paiement::all();
        $clients = Client::where('id_magasin', 1)->get();
        return view('Espace_Magas.add-vente_gros-form')->withData($data)->withMagasin($magasin)->withModesPaiement($modes)->withClients($clients);
    }

    public static function printfacture()
    {
        $pdf = PDF::loadView('Espace_Magas.pdf-facture');
        return $pdf->download('facture.pdf');
    }

    public function submitAddVente()
    {
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
        //Notification::send(User::first(), new \App\Notifications\AddVenteMNotification($user));
        //return $this->printfacture(5);


        return redirect()->route('magas.addVente')->withAlertSuccess("Vente effectuée avec succès");
    }
}
