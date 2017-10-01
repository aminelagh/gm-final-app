<?php

namespace App\Http\Controllers;

use App\Models\Stock_taille;
use App\Models\Taille_article;
use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Magasin;
use App\Models\Transaction;
use App\Models\Type_transaction;
use App\Models\Article;
use App\Models\Marque;
use App\Models\Stock;
use App\Models\Trans_article;
use App\Models\Paiement;
use App\Models\Mode_paiement;
use \Exception;
use Notification;
use Illuminate\Support\Facades\Session;

class StockController extends Controller
{
    //afficher le stock du magasin  et du main -------------------------------------------------------------------------
    public function main_stocks()
    {
        //$data = Stock::where('id_magasin', 1)->get();
        $data = collect(DB::select("select * from stocks where id_magasin=1"));
        $magasin = Magasin::find(1);
        $tailles = Taille_article::all();

        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock du magasin principal est vide, vous devez le créer.")->withRouteWarning('/magas/addStock/' . 1);
        else
            return view('Espace_Magas.liste-main_stocks')->withData($data)->withMagasin($magasin)->withTailles($tailles);
    }

    public function stocks($p_id)
    {
        if ($p_id == 1)
            return redirect()->back()->withInput()->withAlertInfo("Vous ne pouvez pas accéder à ce magasin de cette manière.");

        $data = Stock::where('id_magasin', $p_id)->get();
        $magasin = Magasin::find($p_id);
        $tailles = Taille_article::all();

        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock de ce magasin est vide, vous pouvez commencer par le créer.")->withRouteWarning('/magas/addStock/' . $p_id);
        else
            return view('Espace_Magas.liste-stocks')->withData($data)->withMagasin($magasin)->withTailles($tailles);
    }

    //------------------------------------------------------------------------------------------------------------------
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

        return view('Espace_Magas.info-stock')->withData($data)->withMagasin($magasin)->withStock($stock)->withArticle($article);
    }

    //Creation du stock de tt les magasins -----------------------------------------------------------------------------
    public function addStock($p_id)
    {
        $magasin = Magasin::find($p_id);
        $articles = collect(DB::select("call getArticlesForStock(" . $p_id . "); "));

        if ($magasin == null)
            return redirect()->back()->withInput()->with('alert_warning', "Le magasin choisi n'existe pas.");

        if ($articles == null)
            return redirect()->back()->withInput()->with('alert_warning', "La base de données des articles est vide, veuillez ajouter les articles avant de procéder à la création des stocks.");

        return view('Espace_Magas.add-stock-form')->withMagasin($magasin)->withArticles($articles);
    }

    public function submitAddStock(Request $request)
    {
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\AddStockNotification($user));
        return Stock::addStock($request);
    }
    //------------------------------------------------------------------------------------------------------------------

    //Stock IN for main magasin ----------------------------------------------------------------------------------------
    public function addStockIN()
    {
        $p_id_magasin = 1;
        Session::get('id_magasin');
        $data = Stock::where('id_magasin', $p_id_magasin)->get();
        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Cet element du stock n'existe pas.");

        $magasin = Magasin::find(1);
        $tailles = Taille_article::all();
        return view('Espace_Magas.add-stockIN-form')->withData($data)->withMagasin($magasin)->withTailles($tailles);
    }

    public function submitAddStockIN()
    {
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\AddStockINNotification($user));
        return Stock::addStockIN(request());
    }
    //------------------------------------------------------------------------------------------------------------------
    //Stock OUT for main magasin ---------------------------------------------------------------------------------------
    public function addStockOUT()
    {
        $p_id_magasin = 1;//Session::get('id_magasin');
        $data = Stock::where('id_magasin', $p_id_magasin)->get();
        if ($data == null)
            return redirect()->back()->withInput()->withAlertWarning("Cet element du stock n'existe pas.");

        $magasin = Magasin::find(1);
        $tailles = Taille_article::all();
        return view('Espace_Magas.add-stockOUT-form')->withMagasin($magasin)->withData($data)->withTailles($tailles);
    }

    public function submitAddStockOUT()
    {
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\AddStockOUTNotification($user));
        return Stock::addStockOUT(request());
    }
    //------------------------------------------------------------------------------------------------------------------
    //Stock OUT for main magasin ---------------------------------------------------------------------------------------
    public function addStockTransfertOUTall()
    {
        $data = Stock::where('id_magasin', 1)->get();
        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Le stock du magasin principal est vide, veuillez commencer par l'alimenter avant de procéder à un transfert.");

        $magasins = Magasin::where('id_magasin', '!=', 1)->get();
        if ($magasins->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Veuillez creer des magasins avant de proceder a un transfert.");

        $magasinSource = Magasin::find(1);
        $tailles = Taille_article::all();

        return view('Espace_Magas.add-stockTransfertOUTall-form')->withMagasinSource($magasinSource)->withMagasins($magasins)->withData($data)->withTailles($tailles);
    }

    public function addStockTransfertOUT($p_id_magasin_destination)
    {
        $data = Stock::where('id_magasin', 1)->get();
        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Le stock du magasin principal est vide, veuillez commencer par l'alimenter avant de procéder à un transfert.");

        $magasinDestination = Magasin::find($p_id_magasin_destination);
        if ($magasinDestination == null)
            return redirect()->back()->withInput()->withAlertWarning("le magasin choisi n'existe pas.");

        $magasinSource = Magasin::find(1);
        $tailles = Taille_article::all();

        return view('Espace_Magas.add-stockTransfertOUT-form')->withMagasinSource($magasinSource)->withMagasinDestination($magasinDestination)->withData($data)->withTailles($tailles);
    }

    public function submitAddStockTransfertOUT()
    {
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\AddStockTransfertOUTNotification($user));
        return Stock::addStockTransfertOUT(request());
    }

    public function addStockTransfertIN($p_id_magasin_source)
    {
        //return back()->withAlertInfo("Transfert IN is not set for the moment.");
        $data = Stock::where('id_magasin', $p_id_magasin_source)->get();
        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Le stock du magasin <b>" . Magasin::getLibelle($p_id_magasin_source) . "</b> est vide, veuillez commencer par l'alimenter avant de procéder à un transfert.");

        $magasinSource = Magasin::find($p_id_magasin_source);
        if ($magasinSource == null)
            return redirect()->back()->withInput()->withAlertWarning("le magasin choisi n'existe pas.");

        $magasinDestination = Magasin::find(1);
        //$tailles = Taille_article::all();

        return view('Espace_Magas.add-stockTransfertIN-form')->withMagasinSource($magasinSource)->withMagasinDestination($magasinDestination)->withData($data);//->withTailles($tailles);
    }

    public function submitAddStockTransfertIN()
    {
        //$user = User::where('id', Session::get('id_user'))->get()->first();
        //Notification::send(User::first(), new \App\Notifications\AddStockTransfertINNotification($user));
        return Stock::addStockTransfertIN(request());
    }
    //------------------------------------------------------------------------------------------------------------------


    /*public function listerStocks($p_id_magasin)
    {
        $data = Stock::where('id_magasin', $p_id_magasin)->get();
        if ($data->isEmpty())
            return redirect()->back()->withInput()->with('alert_warning', "Le stock de ce magasin est vide.");
        else
            return view('Espace_Magas.liste-stocks')->with('data', $data);
    }*/


}
