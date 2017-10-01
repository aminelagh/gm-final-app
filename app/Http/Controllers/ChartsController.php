<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Categorie;
use App\Models\User;
use App\Models\Role;
use App\Models\Stock;
use App\Models\Stock_taille;
use App\Models\Promotion;
use App\Models\Article;
use Charts;
use Khill\Lavacharts\Lavacharts;

class ChartsController extends Controller
{
  public function index()
      {
      $lava=new lavacharts;
      $stock=$lava->DataTable();
      $data=Stock_taille::select("id_article","quantite")->get()->toArray();
      $stock->addStrigColumn("Article")
            ->addNumberColumn("quantite")
            ->addRows($data);
      $lava->BarChart("Stock par taille",$stock);
      return view('Espace_Magas.dashboard', ['lava' => $lava]);





//---------------------------------------Line Chart ------------------------------------------
     $chart = Charts::database(User::all(), 'line', 'highcharts')
     ->title("Nombre d'utilisateurs par role ")
     ->elementLabel("Total")
     ->dimensions(600, 500)
     ->responsive(true)
     ->groupBy('id_role')
     ->labels(['Administrateur','Direction','Magasinier','Vendeur']);

     //---------------------------------------Bar Chart ------------------------------------------

     $chart2 = Charts::database(User::all(), 'bar', 'highcharts')
     ->title("Nombre d'utilisateurs par role ")
     ->elementLabel("Total")
     ->dimensions(600, 500)
     ->responsive(true)
     ->groupBy('id_role')
     ->labels(['Administrateur','Direction','Magasinier','Vendeur']);
     //---------------------------------------Pie Chart ------------------------------------------

     $chart3 = Charts::database(User::all(), 'pie', 'highcharts')
     ->title("Nombre d'utilisateurs par role ")

     ->elementLabel("Total")
     ->dimensions(700, 500)
     ->responsive(true)
     ->groupBy('id_role')
     ->labels(['Administrateur','Direction','Magasinier','Vendeur']);

     //---------------------------------------area Chart ------------------------------------------

     $chart4 = Charts::database(User::all(), 'area', 'highcharts')
     ->title("Nombre d'utilisateurs par role ")

     ->elementLabel("Total")
     ->dimensions(600, 500)
     ->responsive(true)
     ->groupBy('id_role')
     ->labels(['Administrateur','Direction','Magasinier','Vendeur']);

     return view('Espace_Admin.charts', ['chart' => $chart,'chart2' => $chart2,'chart3' => $chart3,'chart4' => $chart4]);


      }

}
