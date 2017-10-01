<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use DB;
use Hash;
use App\Models\User;
use App\Models\Agent;
use App\Models\Magasin;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\Marque;
use App\Models\Stock;
use \Exception;

class ShowController extends Controller
{
    /****************************************
     * info: retourner la vue pour afficher les details
     *****************************************/
    /*public function info($p_table, $p_id)
    {
        switch ($p_table) {

            case 'agents':
                $item = Agent::find($p_id);
                return ($item != null ? view('Espace_Magas.info-agent')->with('data', $item) : back()->withInput()->with('alert_warning', "L'agent choisi n'existe pas."));
                break;
            case 'categories':
                $item = Categorie::find($p_id);
                return ($item != null ? view('Espace_Magas.info-categorie')->with('data', $item) : back()->withInput()->with('alert_warning', "La catégorie choisie n'existe pas."));
                break;
            case 'marques':
                $item = Marque::find($p_id);
                $articles = Article::where('id_marque', $p_id)->get();
                //dump( $articles->isEmpty() );
                //dump($articles);return 'a';
                return ($item != null ? view('Espace_Magas.info-marque')->with('data', $item)->with('articles', $articles) : back()->withInput()->with('alert_warning', "La marque choisie n'existe pas."));
                break;
            case 'fournisseurs':
                $item = fournisseur::find($p_id);
                $agents = Agent::getAgents($p_id);
                return ($item != null ? view('Espace_Magas.info-fournisseur')->with(['data' => $item, 'agents' => $agents]) : back()->withInput()->with('alert_warning', "Le fournisseur choisi n'existe pas."));
                break;
            case 'articles':
                $item = Article::find($p_id);
                return ($item != null ? view('Espace_Magas.info-article')->with('data', $item) : back()->withInput()->with('alert_warning', "L'article choisi n'existe pas."));
                break;
            case 'promotions':
                $data = collect(DB::select("call getPromotion(" . $p_id . ");"))->first();
                return ($data != null ? view('Espace_Direct.info-promotion')->with('data', $data) : back()->withInput()->with('alert_warning', "La promotion choisie n'existe pas."));
                break;
            case 'promotions2':
                $item = Article::find($p_id);
                return ($item != null ? view('Espace_Direct.info-article')->with('data', $item) : back()->withInput()->with('alert_warning', "La promotion choisie n'existe pas."));
                break;
            case 'magasins':
                $item = Magasin::find($p_id);
                return ($item != null ? view('Espace_Magas.info-magasin')->with(['data' => $item, 'stocks' => Stock::where('id_magasin', $p_id)->get()]) : back()->withInput()->with('alert_warning', 'Le magasin choisi n\'existe pas'));
                break;
            case 'dashboard-fourniseur':
                $item = fournisseur::find($p_id);
                $articles = Article::where('id_fournisseur', $p_id)->get();
                //$count = collect(DB::select("select f.id_fournisseur,count(a.id_article) from fournisseurs f JOIN articles a on f.id_fournisseur=a.id_fournisseur GROUP By id_fournisseur"));
                return ($item != null ? view('Espace_Direct.dashboard-fourniseur')->with(
                    [
                        'data' => $item,
                        'articles' => $articles
                    ]

                ) : back()->withInput()->with('alert_warning', "Le fournisseur choisi n'existe pas."));
                break;
            case 'dashboard-magasin':
                $data = Magasin::find($p_id);
                $articles = Article::all();//where('id_magasin',$p_id)->get();
                //$ventes = collect(DB::select("call getVentes(".$p_id.");") );
                return ($data != null ? view('Espace_Direct.dashboard-magasin')->with(
                    [
                        'data' => $data,
                        'articles' => $articles
                    ]

                ) : back()->withInput()->with('alert_warning', "Le magasin choisi n'existe pas."));
                break;
            default:
                return back()->withInput()->with('alert_warning', 'Vous avez pris le mauvais chemin. ==> ShowController@info');
                break;
        }
    }*/

    /****************************************
     * retourner la vue pour afficher les tables
     *****************************************/
    /*public function lister($p_table)
    {
        switch ($p_table) {
            case 'agents':
                $data = Agent::whereDeleted(false)->orWhere('deleted', null)->get();
                return view('Espace_Magas.liste-agents')->with('data', $data);
                break;
            case 'categories':
                $data = Categorie::whereDeleted(false)->orWhere('deleted', null)->get();
                return view('Espace_Magas.liste-categories')->with('data', $data);
                break;
            case 'marques':
                $data = Marque::whereDeleted(false)->orWhere('deleted', null)->get();
                return view('Espace_Magas.liste-marques')->with('data', $data);
                break;
            case 'fournisseurs':
                $data = Fournisseur::whereDeleted(false)->orWhere('deleted', null)->get();
                return view('Espace_Magas.liste-fournisseurs')->with('data', $data);
                break;
            case 'articles':
                $data = Article::whereDeleted(false)->orWhere('deleted', null)->get();
                return view('Espace_Magas.liste-articles')->with('data', $data);
                break;
            case 'magasins':
                $data = Magasin::whereDeleted(false)->orWhere('deleted', null)->get();
                return view('Espace_Magas.liste-magasins')->with('data', $data);
                break;
            case 'promotions':
                $data = collect(DB::select("call getPromotions;")); //$data = Promotion::all();
                return view('Espace_Direct.liste-promotions')->with('data', $data);
                break;
            default:
                return back()->withInput()->with('alert_warning', 'Vous avez pris le mauvais chemin. ==> ShowController@lister');
        }
    }*/


}
