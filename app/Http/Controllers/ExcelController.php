<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Vente;
use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Magasin;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\Marque;
use App\Models\Stock;
use \Exception;
use \Excel;
use Carbon\Carbon;


class ExcelController extends Controller
{

    public function export($p_table)
    {
        switch ($p_table) {
            case 'users':
                $this->ExportUsers();
                break;
            case 'fournisseurs':
                $this->ExportFournisseurs();
                break;
            case 'categories':
                $this->ExportCategories();
                break;
            case 'marques':
                $this->ExportMarques();
                break;
            case 'articles_nv':
                $this->ExportArticles_nv();
                break;
            case 'articles':
                $this->ExportArticles();
                break;
            case 'promotions':
                $this->ExportPromotions();
                break;
            case 'entrees':
                $this->ExportEntrees();
                break;
            case 'sorties':
                $this->ExportSorties();
                break;
            case 'transfertINs':
                $this->ExportTransfertINs();
                break;
            case 'transfertOUTs':
                $this->ExportTransfertOUTs();
                break;
            case 'ventes':
                $this->ExportVentes();
                break;
            default:
                return redirect()->back()->withInput()->with('alert_warning', ' Vous avez pris le mauvais chemin.');
                break;
        }
    }

    //fonction pour exporter la liste des utilisateurs
    public function ExportUsers()
    {
        $carbon = new Carbon();
        $date = $carbon->format('d/m/Y H:m');

        Excel::create('Utilisateurs ' . $date, function ($excel) {
            $excel->sheet('Utilisateurs', function ($sheet) {
                //$data = User::all();
                $data = collect(DB::select("
                          SELECT u.*, m.libelle, r.name
                          FROM users u JOIN magasins m on m.id_magasin=u.id_magasin
                          LEFT JOIN role_users ru on ru.user_id=u.id
                          LEFT JOIN roles r on ru.role_id=r.id
                          WHERE u.id!=1;"));
                $i = 2;
                //$sheet->setOrientation('landscape');
                $sheet->with(array('Role', 'Magasin', 'nom', 'prenom', 'ville', 'telephone', 'email', 'Date de creation'));
                foreach ($data as $item) {
                    $sheet->row($i++,
                        array(
                            $item->name,
                            $item->libelle != null ? $item->libelle : 'Aucun',
                            $item->nom, $item->prenom,
                            $item->ville,
                            $item->telephone,
                            $item->email,
                            getDateHelper($item->created_at) . ' à ' . getTimeHelper($item->created_at)
                        )
                    );
                }
            });
        })->export('xls');
    }

    //fonction pour exporter la liste des articles
    public function ExportArticles()
    {
        $carbon = new Carbon();
        $date = $carbon->format('d/m/Y H:m');

        Excel::create('Articles ' . $date, function ($excel) {
            $excel->sheet('Articles', function ($sheet) {
                $data = Article::where('deleted', false)->where('valide', true)->get();
                /*$data = collect(DB::select("
                          SELECT u.*, m.libelle, r.name
                          FROM users u JOIN magasins m on m.id_magasin=u.id_magasin
                          LEFT JOIN role_users ru on ru.user_id=u.id
                          LEFT JOIN roles r on ru.role_id=r.id
                          WHERE u.id!=1;"));*/
                $i = 2;
                //$sheet->setOrientation('landscape');
                $sheet->with(array('Réference', 'Code', 'Désignation', 'Couleur', 'Sexe', 'Prix d\'achat  (HT)', 'Prix d\'achat  (TTC)', 'Prix de vente (HT)', 'Prix de vente (TTC)'));
                foreach ($data as $item) {
                    $sheet->row($i++,
                        array(
                            $item->ref . ' - ' . $item->alias,
                            $item->code,
                            $item->designation,
                            $item->couleur,
                            $item->sexe,
                            number_format($item->prix_a, 2),
                            number_format($item->prix_a * 1.2, 2),
                            number_format($item->prix_v, 2),
                            number_format($item->prix_v * 1.2, 2),
                        )
                    );
                }
            });
        })->export('xls');
    }

    //fonction pour exporter la liste des utilisateurs
    public function ExportFournisseurs()
    {
        $carbon = new Carbon();
        $date = $carbon->format('d/m/Y H:m:s');

        Excel::create('Fournisseurs ' . $date, function ($excel) {
            $excel->sheet('Fournisseurs', function ($sheet) {
                $data = Fournisseur::all();
                $i = 2;
                //$sheet->setOrientation('landscape');
                $sheet->fromArray(array('code', 'Nom', 'agent', 'email', 'telephone', 'fax', 'description', 'Date de creation'));
                foreach ($data as $item) {
                    $sheet->row($i++,
                        array(
                            $item->code,
                            $item->libelle,
                            $item->agent,
                            $item->email,
                            $item->telephone,
                            $item->fax,
                            $item->description,
                            getDateHelper($item->created_at) . ' à ' . getTimeHelper($item->created_at))
                    );
                }
            });
        })->download('xls');
    }

    //fonction pour exporter la liste des categories
    public function ExportCategories()
    {
        $carbon = new Carbon();
        $date = $carbon->format('d/m/Y H:m:s');

        Excel::create('Categories ' . $date, function ($excel) {
            $excel->sheet('Fournisseurs', function ($sheet) {
                $data = Categorie::all();
                $i = 2;
                //$sheet->setOrientation('landscape');
                $sheet->fromArray(array('Categorie', 'description', 'Date de creation'));
                foreach ($data as $item) {
                    $sheet->row($i++,
                        array(
                            $item->libelle,
                            $item->description,
                            getDateHelper($item->created_at) . ' à ' . getTimeHelper($item->created_at))
                    );
                }
            });
        })->download('xls');
    }

    //fonction pour exporter la liste des promotions
    public function ExportPromotions()
    {
        $carbon = new Carbon();
        $date = $carbon->format('d/m/Y H:m');

        Excel::create('Promotions ' . $date, function ($excel) {
            $excel->sheet('Promotions', function ($sheet) {
                $data = collect(DB::select("
                          SELECT p.*,a.*,m.libelle as libelle_magasin
                          FROM promotions p LEFT JOIN articles a ON p.id_article=a.id_article
                          LEFT JOIN magasins m ON m.id_magasin=p.id_magasin
                          WHERE p.deleted=false; "));
                $i = 2;
                //$sheet->setOrientation('landscape');
                $sheet->fromArray(array('Réference', 'Code à barres', 'Article', 'Magasin', 'Taux', 'Date de debut', 'Date de fin', 'Etat'));
                foreach ($data as $item) {
                    $sheet->row($i++,
                        array(
                            $item->ref . ' - ' . $item->alias,
                            $item->code,
                            $item->designation,
                            $item->libelle_magasin,
                            $item->taux,
                            getShortDateHelper($item->date_debut),
                            getShortDateHelper($item->date_fin),
                            $item->active == true ? 'Active' : 'Inactive'
                        )
                    );
                }
            });
        })->download('xls');
    }

    //fonction pour exporter la liste des entrees de stock
    public function ExportEntrees()
    {
        $carbon = new Carbon();
        $date = $carbon->format('d/m/Y H:m:s');

        Excel::create('Entrees de stock ' . $date, function ($excel) {
            $excel->sheet('Entrees de stock', function ($sheet) {
                $data = collect(DB::select("
                          select t.*,m.libelle,u.nom,u.prenom
                          FROM transactions t LEFT JOIN users u ON t.id_user=u.id JOIN magasins m ON t.id_magasin=m.id_magasin
                          WHERE id_type_transaction=1 AND t.annulee=false
                          ORDER BY id_transaction desc "));
                $i = 2;
                //$sheet->setOrientation('landscape');
                $sheet->fromArray(array('Date', 'Heure', 'Utilisateur', 'Nombre d\'article', 'Nombre total de pièces'));
                foreach ($data as $item) {
                    $sheet->row($i++,
                        array(
                            getShortDateHelper($item->date),
                            getTimeHelper($item->date),
                            $item->nom . ' ' . $item->prenom,
                            Transaction::getNombreArticles($item->id_transaction) . ' article(s)',
                            Transaction::getNombrePieces($item->id_transaction) . ' pièce(s)'
                        )
                    );
                }
            });
        })->download('xls');
    }

    //fonction pour exporter la liste des sorties de stock
    public function ExportSorties()
    {
        $carbon = new Carbon();
        $date = $carbon->format('d/m/Y H:m:s');

        Excel::create('Sorties de stock ' . $date, function ($excel) {
            $excel->sheet('Sorties de stock', function ($sheet) {
                $data = collect(DB::select("
                          select t.*,m.libelle,u.nom,u.prenom
                          FROM transactions t LEFT JOIN users u ON t.id_user=u.id JOIN magasins m ON t.id_magasin=m.id_magasin
                          WHERE id_type_transaction=2 AND t.annulee=false
                          ORDER BY id_transaction desc "));
                $i = 2;
                //$sheet->setOrientation('landscape');
                $sheet->fromArray(array('Date', 'Heure', 'Utilisateur', 'Nombre d\'article', 'Nombre total de pieces'));
                foreach ($data as $item) {
                    $sheet->row($i++,
                        array(
                            getShortDateHelper($item->date),
                            getTimeHelper($item->date),
                            $item->nom . ' ' . $item->prenom,
                            Transaction::getNombreArticles($item->id_transaction) . ' article(s)',
                            Transaction::getNombrePieces($item->id_transaction) . ' pièce(s)'
                        )
                    );
                }
            });
        })->download('xls');
    }

    //fonction pour exporter la liste des transfertINs
    public function ExportTransfertINs()
    {
        $carbon = new Carbon();
        $date = $carbon->format('d/m/Y H:m');

        Excel::create('Transfert IN' . $date, function ($excel) {
            $excel->sheet('Transfert IN', function ($sheet) {
                $data = collect(DB::select("
                            select t.*,m.libelle,u.nom,u.prenom
                            FROM transactions t LEFT JOIN users u ON t.id_user=u.id JOIN magasins m ON t.id_magasin=m.id_magasin
                            WHERE id_type_transaction=3 AND t.annulee=false
                            ORDER BY id_transaction desc "));
                $i = 2;
                //$sheet->setOrientation('landscape');
                $sheet->fromArray(array('Date', 'Heure', 'Utilisateur', 'Magasin source', 'Nombre d\'article', 'Nombre total de pieces'));
                foreach ($data as $item) {
                    $sheet->row($i++,
                        array(
                            getShortDateHelper($item->date),
                            getTimeHelper($item->date),
                            $item->nom . ' ' . $item->prenom,
                            $item->libelle,
                            Transaction::getNombreArticles($item->id_transaction) . ' article(s)',
                            Transaction::getNombrePieces($item->id_transaction) . ' pièce(s)'
                        )
                    );
                }
            });
        })->download('xls');
    }

    //fonction pour exporter la liste des transfertINs
    public function ExportTransfertOUTs()
    {
        $carbon = new Carbon();
        $date = $carbon->format('d/m/Y H:m');

        Excel::create('Transfert OUT ' . $date, function ($excel) {
            $excel->sheet('Transfert OUT', function ($sheet) {
                $data = collect(DB::select("
                            select t.*,m.libelle,u.nom,u.prenom
                            FROM transactions t LEFT JOIN users u ON t.id_user=u.id JOIN magasins m ON t.id_magasin=m.id_magasin
                            WHERE id_type_transaction=4 AND t.annulee=false
                            ORDER BY id_transaction desc "));
                $i = 2;
                //$sheet->setOrientation('landscape');
                $sheet->fromArray(array('Date', 'Heure', 'Utilisateur', 'Magasin destination', 'Nombre d\'article', 'Nombre total de pieces'));
                foreach ($data as $item) {
                    $sheet->row($i++,
                        array(
                            getShortDateHelper($item->date),
                            getTimeHelper($item->date),
                            $item->nom . ' ' . $item->prenom,
                            $item->libelle,
                            Transaction::getNombreArticles($item->id_transaction) . ' article(s)',
                            Transaction::getNombrePieces($item->id_transaction) . ' pièce(s)'
                        )
                    );
                }
            });
        })->download('xls');
    }

    //fonction pour exporter la liste des transfertINs
    public function ExportVentes()
    {
        $carbon = new Carbon();
        $date = $carbon->format('d/m/Y H:m');

        Excel::create('Ventes ' . $date, function ($excel) {
            $excel->sheet('Ventes', function ($sheet) {
                $data = collect(DB::select("
                          SELECT v.*,u.nom,u.prenom,m.libelle
                          from ventes v LEFT JOIN magasins m on v.id_magasin=m.id_magasin LEFT JOIN users u on v.id_user=u.id
                          ORDER BY id_vente desc "));
                $i = 2;
                //$sheet->setOrientation('landscape');
                $sheet->fromArray(array('Date', 'Heure', 'Utilisateur', 'Magasin', 'Nombre d\'article', 'Nombre total de pieces'));
                foreach ($data as $item) {
                    $sheet->row($i++,
                        array(
                            getShortDateHelper($item->date),
                            getTimeHelper($item->date),
                            $item->nom . ' ' . $item->prenom,
                            $item->libelle,
                            Vente::getNombreArticles($item->id_vente) . ' article(s)',
                            Vente::getNombrePieces($item->id_vente) . ' pièce(s)'
                        )
                    );
                }
            });
        })->download('xls');
    }


    //fonction pour exporter la liste des utilisateurs
    /*public function ExportUsers2()
    {
        $carbon = new Carbon();
        $date =  $carbon->format('d/m/Y H:m:s');

        Excel::create('Users '.$date, function($excel)
        {
            //sheet 1
            $excel->sheet('Utilisateurs', function($sheet) {
                $sheet->setFontFamily('Times New Roman');

                $sheet->row(1, function($row){
                    $row->setBackground('#A4A4A4');

                } )->with( array('Role','Magasin', 'nom','prenom','ville','telephone','description','email','Date de creation') );

                //$sheet->row(1,  array('Role','Magasin', 'nom','prenom','ville','telephone','description','email','Date de creation') );


                //$sheet->setFontSize(12);
                //$sheet->setFontBold(false);

                $data = User::all();
                $i=2;
                foreach( $data as $item )
                {
                    $sheet->row( $i++ ,
                    array(
                        getChamp('roles', 'id_role', $item->id_role, 'libelle'),
                        getChamp('magasins', 'id_magasin', $item->id_magasin, 'libelle'),
                        $item->nom,$item->prenom,
                        $item->ville,
                        $item->telephone,
                        $item->description,
                        $item->email,
                        $item->created_at )
                    );
                }
            });

            //sheet 2
            $excel->sheet('Second sheet', function($sheet) { });

        })->download('xls');
    }*/

}
