<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use \Exception;
use Illuminate\Support\Facades\Session;


class Stock extends Model
{
    protected $table = 'stocks';
    protected $primaryKey = 'id_stock';


    protected $fillable = [
        'id_stock', 'id_article', 'id_magasin',
        'quantite_min', 'quantite_max',
    ];

    public static function getIdArticle($id_stock)
    {
        $data = self::find($id_stock);
        return $data->id_article;
    }

    public static function getStockState($p_id_stock)
    {
        $stock = \App\Models\Stock::find($p_id_stock);
        $tailles = \App\Models\Stock_taille::where('id_stock', $p_id_stock)->get();

        if ($tailles->isEmpty())
            return "default";

        foreach ($tailles as $taille) {
            if ($taille->quantite == $stock->quantite_min)
                return "warning";
            elseif ($taille->quantite > $stock->quantite_min)
                return "success";
            elseif ($taille->quantite < $stock->quantite_min)
                return "danger";
        }
    }

    public static function stockExists($id_magasin, $id_article)
    {
        $data = self::where('id_magasin', $id_magasin)->where('id_article', $id_article)->get()->first();
        if ($data == null)
            return false;
        else return true;

    }

    public static function getStock($id_magasin, $id_article)
    {
        $data = self::where('id_magasin', $id_magasin)->where('id_article', $id_article)->get()->first();
        return $data;
    }

    public static function getIdStock($id_magasin, $id_article)
    {
        $data = self::where('id_magasin', $id_magasin)->where('id_article', $id_article)->get()->first();
        return $data->id_stock;
    }

    public static function creerStock($id_magasin, $id_article, $quantite_min, $quantite_max)
    {
        $item = new self();
        $item->id_magasin = $id_magasin;
        $item->id_article = $id_article;
        $item->quantite_min = $quantite_min;
        $item->quantite_max = $quantite_max;
        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de creation de l'article dans le stock.<br>Message d'erreur:<b>" . $e->getMessage() . "</b>");
        }
    }

    public static function getState($id_stock)
    {
        $stock = self::find($id_stock);
        if (!Stock_taille::hasTailles($id_stock))
            return 0;
        else {
            $tailles = Stock_taille::getTailles($id_stock);
            $nombreArticles = self::getNombreArticles($id_stock);
            if ($nombreArticles < $stock->quantite_min)
                return 1;
            elseif ($nombreArticles == $stock->quantite_min)
                return 2;
            else return 3;
        }
    }

    public static function getNombreArticles($id_stock)
    {
        if (!Stock_taille::hasTailles($id_stock))
            return 0;
        else {
            $tailles = Stock_taille::getTailles($id_stock);
            $nbreArticles = 0;
            foreach ($tailles as $item) {
                $nbreArticles += $item->quantite;
            }
        }
        return $nbreArticles;
    }

    //Creer le stock d un magasin
    public static function addStock(Request $request)
    {
        $id_magasin = request()->get('id_magasin');

        //array des element du formulaire ---------------------------------------------------
        $id_article = $request->get('id_article');
        $designation = $request->get('designation');//request()->get('designation');
        $quantite_min = $request->get('quantite_min');//request()->get('quantite_min');
        $quantite_max = $request->get('quantite_max');//request()->get('quantite_max');
        //-----------------------------------------------------------------------------------

        //variable pour des erreur et alaerts --------------
        $error1 = "";
        $hasError1 = false;
        $error2 = "";
        $hasError2 = false;
        $nbre_articles = 0;
        //---------------------------------------------------

        for ($i = 1; $i <= count($id_article); $i++) {
            //verifier si l utilisateur n a pas saisi les quantites min ou Max
            if ($quantite_min[$i] == null || $quantite_max[$i] == null) continue;

            //si erreur de q min et q max --------------------------------
            if ($quantite_min[$i] >= $quantite_max[$i]) {
                $hasError1 = true;
                $error1 = $error1 . "<li>Quantite min > Quantite max pour l'article numero $i: <b>" . $designation[$i] . "</b>";
            }
            //-------------------------------------------------------------

            if ($quantite_min[$i] <= $quantite_max[$i]) {
                $item = new Stock;
                $item->id_magasin = $id_magasin;
                $item->id_article = $id_article[$i];
                $item->quantite_min = $quantite_min[$i];
                $item->quantite_max = $quantite_max[$i];

                try {
                    $item->save();
                    $nbre_articles++;
                } catch (\Exception $e) {
                    $error2 = $error2 . "<li>Erreur d'ajout de l'article: <b>" . $designation[$i] . "</b> <br>Message d'erreur: " . $e->getMessage() . ". ";
                    $hasError2 = true;
                }
            }
        }


        if ($hasError1)
            redirect()->back()->withInput()->withAlertWarning($error1)->withalignWarning("right")->withTimerWarning(5000);
        if ($hasError2)
            redirect()->back()->withInput()->withAlertDanger($error2)->withalignDanger("left")->withTimerDanger(0);
        if ($hasError1 || $hasError2)
            return redirect()->back()->withInput();
        else {
            if ($nbre_articles == 1)
                return redirect()->back()->with('alert_success', 'Ajout de ' . $nbre_articles . ' article.');
            else
                return redirect()->back()->with('alert_success', 'Ajout de ' . $nbre_articles . ' articles.');
        }
    }

    //Stock IN d un magasin
    public static function addStockIN(Request $request)
    {
        //variables du formulaires -------------------------------------------------------------------------------------
        $id_magasin = request()->get('id_magasin');
        $id_stocks = request()->get('id_stock');
        $quantiteINs = request()->get('quantiteIN');
        $id_taille_articles = request()->get('id_taille_article');
        //$quantite = request()->get('quantite');
        //--------------------------------------------------------------------------------------------------------------

        //verifier la validitee des donnees ----------------------------------------------------------------------------
        $hasData = false;
        foreach ($id_stocks as $id_stock) {
            if (isset($quantiteINs[$id_stock])) {
                $i = 1;
                foreach ($quantiteINs[$id_stock] as $quantite) {
                    if ($quantite != null && $quantite > 0) {
                        //echo "handling --> ";
                        $hasData = true;
                    }
                    $i++;
                }
            }
        }
        if (!$hasData)
            return redirect()->back()->withInput()->withAlertInfo("Remplissez les formulaires dans les onglets <b>Stock</b>");
        //--------------------------------------------------------------------------------------------------------------

        //Creation d'une transaction -----------------------------------------------------------------------------------
        $id_transaction = Transaction::getNextID();
        Transaction::createTransactionIN($id_transaction);
        //--------------------------------------------------------------------------------------------------------------

        //Creation des trans_articles ----------------------------------------------------------------------------------
        foreach ($id_stocks as $id_stock) {
            if (isset($quantiteINs[$id_stock])) {
                $stock = Stock::find($id_stock);
                $i = 1;
                foreach ($quantiteINs[$id_stock] as $quantite) {
                    if ($quantite != null && $quantite != 0) {
                        //echo "<li> ( " . $quantite . " - [ " . Taille_article::getTaille($id_taille_articles[$id_stock][$i]) . " , " . $id_taille_articles[$id_stock][$i] . " ] ) ==> ";
                        if (Stock_taille::tailleExiste($id_stock, $id_taille_articles[$id_stock][$i])) {
                            //echo "<b>Exist</b> => increment";
                            //incrementer le stock ---------------------------------------------------------------------
                            Stock_taille::incrementer($id_stock, $id_taille_articles[$id_stock][$i], $quantite);
                            //------------------------------------------------------------------------------------------
                        } else {
                            //echo "<b>NotExist</b> => creer";
                            //Creer une nouvelle ligne dans: Stock_taille ----------------------------------------------
                            Stock_taille::create($id_stock, $id_taille_articles[$id_stock][$i], $quantite);
                            //------------------------------------------------------------------------------------------
                        }
                        //Creer une nouvelle ligne dans: trans_article -------------------------------------------------
                        Trans_article::create($id_transaction, self::getIdArticle($id_stock), $id_taille_articles[$id_stock][$i], $quantite);
                        //----------------------------------------------------------------------------------------------
                    }
                    $i++;
                }
            }
        }
        //--------------------------------------------------------------------------------------------------------------
        return redirect()->back()->withAlertSuccess("Entrée de stock effectuée avec succès");
    }

    //Stock OUT d un magasin
    public static function addStockOUT(Request $request)
    {
        //variables du formulaires -------------------------------------------------------------------------------------
        $id_magasin = request()->get('id_magasin');
        $id_stocks = request()->get('id_stock');
        $quantiteOUTs = request()->get('quantiteOUT');
        //$quantite = request()->get('quantite');
        $id_taille_articles = request()->get('id_taille_article');
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
            return redirect()->back()->withInput()->withAlertInfo("Remplissez les formulaires dans les onglets <b>Stock</b>");
        //--------------------------------------------------------------------------------------------------------------

        //Creation d'une transaction -----------------------------------------------------------------------------------
        $id_transaction = Transaction::getNextID();
        Transaction::createTransactionOUT($id_transaction);
        //--------------------------------------------------------------------------------------------------------------

        //Creation des trans_articles ----------------------------------------------------------------------------------
        foreach ($id_stocks as $id_stock) {
            if (isset($quantiteOUTs[$id_stock])) {
                $stock = Stock::find($id_stock);
                $i = 1;
                foreach ($quantiteOUTs[$id_stock] as $quantite) {
                    if ($quantite != null && $quantite != 0) {
                        //verifier que la taille existe dans Stock_taille ----------------------------------------------
                        if (Stock_taille::tailleExiste($id_stock, $id_taille_articles[$id_stock][$i])) {
                            //decrementer le stock -------------------------------------------------------------
                            Stock_taille::decrementer($id_stock, $id_taille_articles[$id_stock][$i], $quantite);
                            //----------------------------------------------------------------------------------
                        } else {
                            return redirect()->back()->withInput()->withAlertDanger("Une erreur s'est produite lors de la sortie de stock");
                        }
                        //----------------------------------------------------------------------------------------------
                        //Creer une nouvelle ligne dans: trans_article -------------------------------------------------
                        Trans_article::create($id_transaction, self::getIdArticle($id_stock), $id_taille_articles[$id_stock][$i], $quantite);
                        //----------------------------------------------------------------------------------------------
                    }
                    $i++;
                }
            }
        }
        //--------------------------------------------------------------------------------------------------------------
        return redirect()->back()->withAlertSuccess("Sortie de stock effectuée avec succès");
    }

    //Transfert de stock OUT: main magasin vers X(request)
    public static function addStockTransfertOUT(Request $request)
    {
        $id_magasin_source = 1;
        //variables du formulaires -------------------------------------------------------------------------------------
        $id_magasin_destination = request()->get('id_magasin_destination');
        $id_stocks = request()->get('id_stock');
        $quantiteOUTs = request()->get('quantiteOUT');
        $id_article = request()->get('id_article');
        $id_taille_articles = request()->get('id_taille_article');
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
            return redirect()->back()->withInput()->withAlertInfo("Remplissez les formulaires dans les onglets <b>Stock</b>");
        //--------------------------------------------------------------------------------------------------------------

        //Creation d'une transaction -----------------------------------------------------------------------------------
        $id_transaction = Transaction::getNextID();
        Transaction::createTransactionTransfertOUT($id_transaction, $id_magasin_destination);
        //--------------------------------------------------------------------------------------------------------------

        //Creation des trans_articles ----------------------------------------------------------------------------------
        foreach ($id_stocks as $id_stock_source) {

            $stock = Stock::find($id_stock_source);
            $id_article = self::getIdArticle($id_stock_source);
            echo "id_stock: $id_stock_source -- id_article: $id_article <br>";

            //Verifier que, pour l'id_stock X, une quantite existe et >0 -----------------------------------------------
            $hasQuantite = false;
            if (isset($quantiteOUTs[$id_stock_source])) {
                foreach ($quantiteOUTs[$id_stock_source] as $quantite) {
                    if ($quantite != null && $quantite > 0) {
                        $hasQuantite = true;
                    }
                }
            }
            //----------------------------------------------------------------------------------------------------------
            //Si la ligne n existe pas, la creer -----------------------------------------------------------------------
            if (!self::stockExists($id_magasin_destination, $id_article))
                self::creerStock($id_magasin_destination, $id_article, $stock->quantite_min, $stock->quantite_max);
            //----------------------------------------------------------------------------------------------------------

            //recuperer l'id_stock_destination -------------------------------------------------------------------------
            if ($hasQuantite) {
                $data = self::getStock($id_magasin_destination, $id_article);
                $id_stock_destination = $data->id_stock;
            }
            //----------------------------------------------------------------------------------------------------------

            if (isset($quantiteOUTs[$id_stock_source]) && $hasQuantite) {
                $i = 1;

                //Loop pour chaque quantite / taille_article -----------------------------------------------------------
                foreach ($quantiteOUTs[$id_stock_source] as $quantite) {
                    if ($quantite != null && $quantite > 0) {
                        $id_taille_article = $id_taille_articles[$id_stock_source][$i];

                        //si la ligne Stock_taille n'existe pas, la creer ----------------------------------------------
                        if (!Stock_taille::tailleExiste($id_stock_destination, $id_taille_article))
                            Stock_taille::create($id_stock_destination, $id_taille_article, 0);
                        //----------------------------------------------------------------------------------------------

                        //Decrementer le Stock du magasin source -------------------------------------------------------
                        Stock_taille::decrementer($id_stock_source, $id_taille_article, $quantite);
                        //----------------------------------------------------------------------------------------------
                        //Incrementer le Stock du magasin destination: -------------------------------------------------
                        Stock_taille::incrementer($id_stock_destination, $id_taille_article, $quantite);
                        //----------------------------------------------------------------------------------------------

                        //Creer une nouvelle ligne dans: trans_article -------------------------------------------------
                        //Trans_article::create($id_transaction, self::getIdArticle($id_stock), $id_taille_article, $quantite);
                        Trans_article::create($id_transaction, $id_article, $id_taille_article, $quantite);
                        //----------------------------------------------------------------------------------------------
                    }
                    $i++;
                }
                //------------------------------------------------------------------------------------------------------
            }
        }
        //--------------------------------------------------------------------------------------------------------------
        Stock_taille::deleteEmptyItems();
        return redirect()->back()->withAlertSuccess("Transfert vers le stock du magasin <b>" . Magasin::getLibelle($id_magasin_destination) . "</b>effectuée avec succès");
    }

    //Transfert de stock IN: main magasin vers X(request)
    public static function addStockTransfertIN(Request $request)
    {
        $id_magasin_destination = 1;
        //variables du formulaires -------------------------------------------------------------------------------------
        $id_magasin_source = request()->get('id_magasin_source');
        $id_stocks = request()->get('id_stock');
        $quantiteINs = request()->get('quantiteIN');
        $id_article = request()->get('id_article');
        $id_taille_articles = request()->get('id_taille_article');
        //--------------------------------------------------------------------------------------------------------------

        //verifier la validitee des donnees ----------------------------------------------------------------------------
        $hasData = false;
        foreach ($id_stocks as $id_stock) {
            if (isset($quantiteINs[$id_stock])) {
                $i = 1;
                foreach ($quantiteINs[$id_stock] as $quantite) {
                    if ($quantite != null && $quantite > 0) {
                        $hasData = true;
                    }
                    $i++;
                }
            }
        }
        if (!$hasData)
            return redirect()->back()->withInput()->withAlertInfo("Remplissez les formulaires dans les onglets <b>Stock</b>");
        //--------------------------------------------------------------------------------------------------------------

        //Creation d'une transaction -----------------------------------------------------------------------------------
        $id_transaction = Transaction::getNextID();
        Transaction::createTransactionTransfertIN($id_transaction, $id_magasin_source);
        //--------------------------------------------------------------------------------------------------------------

        //Creation des trans_articles ----------------------------------------------------------------------------------
        foreach ($id_stocks as $id_stock_source) {

            $stock = Stock::find($id_stock_source);
            $id_article = self::getIdArticle($id_stock_source);

            //Verifier que, pour l'id_stock X, une quantite existe et >0 -----------------------------------------------
            $hasQuantite = false;
            if (isset($quantiteINs[$id_stock_source])) {
                foreach ($quantiteINs[$id_stock_source] as $quantite) {
                    if ($quantite != null && $quantite > 0) {
                        $hasQuantite = true;
                    }
                }
            }
            //----------------------------------------------------------------------------------------------------------
            //Si la ligne n existe pas, la creer -----------------------------------------------------------------------
            if (!self::stockExists($id_magasin_destination, $id_article) && $hasQuantite)
                self::creerStock($id_magasin_destination, $id_article, $stock->quantite_min, $stock->quantite_max);
            //----------------------------------------------------------------------------------------------------------

            //recuperer l'id_stock_destination -------------------------------------------------------------------------
            if ($hasQuantite) {
                $data = self::getStock($id_magasin_destination, $id_article);
                $id_stock_destination = $data->id_stock;
            }
            //----------------------------------------------------------------------------------------------------------

            if (isset($quantiteINs[$id_stock_source]) && $hasQuantite) {
                $i = 1;

                //Loop pour chaque quantite / taille_article -----------------------------------------------------------
                foreach ($quantiteINs[$id_stock_source] as $quantite) {
                    if ($quantite != null && $quantite > 0) {
                        $id_taille_article = $id_taille_articles[$id_stock_source][$i];

                        //si la ligne Stock_taille n'existe pas, la creer ----------------------------------------------
                        if (!Stock_taille::tailleExiste($id_stock_destination, $id_taille_article))
                            Stock_taille::create($id_stock_destination, $id_taille_article, 0);
                        //----------------------------------------------------------------------------------------------

                        //Decrementer le Stock du magasin source -------------------------------------------------------
                        Stock_taille::decrementer($id_stock_source, $id_taille_article, $quantite);
                        //----------------------------------------------------------------------------------------------
                        //Incrementer le Stock du magasin destination: -------------------------------------------------
                        Stock_taille::incrementer($id_stock_destination, $id_taille_article, $quantite);
                        //----------------------------------------------------------------------------------------------

                        //Creer une nouvelle ligne dans: trans_article -------------------------------------------------
                        Trans_article::create($id_transaction, self::getIdArticle($id_stock_source), $id_taille_article, $quantite);
                          //Trans_article::create($id_transaction, $id_article ,$id_taille_article, $quantite);
                        //----------------------------------------------------------------------------------------------

                    }
                    $i++;
                }
                //------------------------------------------------------------------------------------------------------
            }
        }
        //--------------------------------------------------------------------------------------------------------------
        Stock_taille::deleteEmptyItems();
        return redirect()->back()->withAlertSuccess("Transfert vers le stock du magasin <b>" . Magasin::getLibelle($id_magasin_destination) . "</b>effectuée avec succès");
    }
}
