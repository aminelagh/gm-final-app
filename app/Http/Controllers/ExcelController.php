<?php

namespace App\Http\Controllers;

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
		switch($p_table)
		{
			case 'users': 				$this->ExportUsers(); 				break;
			case 'fournisseurs': 	$this->ExportFournisseurs(); 	break;
			case 'categories': 		$this->ExportCategories(); 		break;
			default: return redirect()->back()->withInput()->with('alert_warning',' Vous avez pris le mauvais chemin. ==> ExcelController@export');      break;
		}
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

	//fonction pour exporter la liste des utilisateurs
	public function ExportUsers()
	{
		$carbon = new Carbon();
		$date =  $carbon->format('d/m/Y H:m:s');

		Excel::create('T '.$date, function($excel)
		{
			$excel->sheet('Utilisateurs', function($sheet)
			{
				$data = User::all(); $i=2;
				//$sheet->setOrientation('landscape');
				$sheet->with( array('Role','Magasin', 'nom','prenom','ville','telephone','description','email','Date de creation') );
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
						getDateHelper($item->created_at).' à '.getTimeHelper($item->created_at)
						)
					);
				}
			});
		})->download('xls');
	}

	//fonction pour exporter la liste des utilisateurs
	public function ExportFournisseurs()
	{
		$carbon = new Carbon();
		$date =  $carbon->format('d/m/Y H:m:s');

		Excel::create('Fournisseurs '.$date, function($excel)
		{
			$excel->sheet('Fournisseurs', function($sheet)
			{
				$data = Fournisseur::all(); $i=2;
				//$sheet->setOrientation('landscape');
				$sheet->fromArray( array('code','Nom','agent','email','telephone','fax','description','Date de creation') );
				foreach( $data as $item )
				{
					$sheet->row( $i++ ,
					array(
						$item->code,$item->libelle,
						$item->agent,$item->email,
						$item->telephone,$item->fax,
						$item->description,
						getDateHelper($item->created_at).' à '.getTimeHelper($item->created_at))
					);
				}
			});
		})->download('xls');
	}

	//fonction pour exporter la liste des categories
	public function ExportCategories()
	{
		$carbon = new Carbon();
		$date =  $carbon->format('d/m/Y H:m:s');

		Excel::create('Categories '.$date, function($excel)
		{
			$excel->sheet('Fournisseurs', function($sheet)
			{
				$data = Categorie::all(); $i=2;
				//$sheet->setOrientation('landscape');
				$sheet->fromArray( array('Categorie','description','Date de creation') );
				foreach( $data as $item )
				{
					$sheet->row( $i++ ,
					array(
						$item->libelle,
						$item->description,
						getDateHelper($item->created_at).' à '.getTimeHelper($item->created_at))
					);
				}
			});
		})->download('xls');
	}

}
