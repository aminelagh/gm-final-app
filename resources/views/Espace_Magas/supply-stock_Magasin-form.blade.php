@extends('layouts.main_master')

@section('title') Alimenter stock du magasin {{ $magasin->libelle }} @endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Ajouter au Stock du magasin {{ $magasin->libelle }}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Gestion des magasins</li>
                    <li class="breadcrumb-item"><a href="{{ Route('magas.lister',['p_table' => 'magasins' ]) }}">Liste
                            des magasins</a></li>
                    <li class="breadcrumb-item">{{ $magasin->libelle }}</li>
                    <li class="breadcrumb-item"><a
                                href="{{ route('magas.stocks', [ 'p_id_magasin' => $magasin->id_magasin ] ) }}">Stock
                            du magasin</a></li>
                    <li class="breadcrumb-item active">Entree de stock</li>
                </ol>

                @include('layouts.alerts')

                <div class="breadcrumb">
                    Afficher/Masquer:
                    <a class="toggle-vis" data-column="1" title="cliquez pour afficher/masquer la colonne categorie">Categorie</a>
                    -
                    <a class="toggle-vis" data-column="2">Fournisseur</a> -
                    <a class="toggle-vis" data-column="3">Designation</a> -
                    <a class="toggle-vis" data-column="4">Numero</a> -
                    <a class="toggle-vis" data-column="5">Code</a> -
                    <a class="toggle-vis" data-column="6">Taille</a> -
                    <a class="toggle-vis" data-column="7">Couleur</a> -
                    <a class="toggle-vis" data-column="8">Sexe</a> -
                    <a class="toggle-vis" data-column="9">Prix d'achat</a> -
                    <a class="toggle-vis" data-column="10">Prix de vente</a>
                </div>

                <!-- Row table -->
                <div class="row">
                    <div class="table-responsive">
                        <div class="col-lg-12">
                            {{-- *************** begin form ***************** --}}
                            <form role="form" method="post" action="{{ Route('magas.submitSupplyStock') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="id_magasin" value="{{ $magasin->id_magasin }}"/>

                                <table id="example" class="table table-striped table-bordered table-hover" width="100%">
                                    <thead bgcolor="#DBDAD8">
                                    <tr>
                                        <th>#</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Categorie</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Fournisseur</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Designation</th>
                                        <th><i class="fa fa-fw fa-sort"></i> numero</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Code</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Taille</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Couleur</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Sexe</th>
                                        <th title="prix HT"><i class="fa fa-fw fa-sort"></i> Prix d'achat</th>
                                        <th title="prix HT"><i class="fa fa-fw fa-sort"></i> Prix de vente</th>
                                        <th>Quantité actuelle</th>
                                        <th title="Quantité a alimenter">Alimenter</th>
                                        <th>Autres</th>
                                    </tr>
                                    </thead>
                                    <tfoot bgcolor="#DBDAD8">
                                    <tr>
                                        <th></th>
                                        <th>Categorie</th>
                                        <th>Fournisseur</th>
                                        <th>Designation</th>
                                        <th>numero</th>
                                        <th>Code</th>
                                        <th>Taille</th>
                                        <th>Couleur</th>
                                        <th>Sexe</th>
                                        <th title="prix HT">Prix d'achat</th>
                                        <th>Prix de vente</th>
                                        <th>Quantite</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach( $data as $item )
                                        <tr>
                                            <input type="hidden" name="id_stock[{{ $loop->index+1 }}]"
                                                   value="{{ $item->id_stock }}">

                                            <input type="hidden" name="id_article[{{ $loop->index+1 }}]"
                                                   value="{{ $item->id_article }}">
                                            {{-- <input type="hidden" name="designation_c[{{ $loop->index+1 }}]" value="{{ $item->designation_c }}">--}}

                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ getChamp('categories', 'id_categorie', $item->id_categorie, 'libelle') }}</td>
                                            <td>{{ getChamp('fournisseurs', 'id_fournisseur', $item->id_fournisseur, 'libelle') }}</td>
                                            <td>{{ $item->designation_c }}</td>
                                            <td>{{ $item->num_article }}</td>
                                            <td>{{ $item->code_barre }}</td>
                                            <td>{{ $item->taille }}</td>
                                            <td>{{ $item->couleur }}</td>
                                            <td>{{ getSexeName($item->sexe) }}</td>
                                            <td align="right">{{ $item->prix_achat }} DH</td>
                                            <td align="right">{{ $item->prix_vente }} DH</td>
                                            <td>{{ $item->quantite }}
                                                article(s), {{ ($item->quantite/$item->quantite_max)*100 }}%
                                            </td>
                                            <td><input type="number" min="0" placeholder="Quantite"
                                                       name="quantite[{{ $loop->index+1 }}]"
                                                       value="{{ old('quantite[$loop->index+1]') }}"></td>
                                            <td>
                                                <button type="button" class="btn btn-info" data-toggle="modal"
                                                        data-target="#myModal{{ $loop->index+1 }}">Detail Article
                                                </button>
                                            </td>

                                            {{-- Modal (pour afficher les details de chaque article) --}}
                                            <div class="modal fade" id="myModal{{ $loop->index+1 }}" role="dialog">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                &times;
                                                            </button>
                                                            <h4 class="modal-title">{{ $item->designation_c }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><b>Quantité </b> {{ $item->quantite }}
                                                                article(s), {{ 100*($item->quantite/$item->quantite_max) }}
                                                                %</p>
                                                            <p><b>Quantité Min</b> {{ $item->quantite_min }}</p>
                                                            <hr>
                                                            <p><b>numero</b> {{ $item->num_article }}</p>
                                                            <p><b>code a barres</b> {{ $item->code_barre }}</p>
                                                            <p><b>Taille</b> {{ $item->taille }}</p>
                                                            <p><b>Couleur</b> {{ $item->couleur }}</p>
                                                            <p><b>sexe</b> {{ getSexeName($item->sexe) }}</p>
                                                            <p><b>Prix d'achat</b> {{ $item->prix_achat }} DH</p>
                                                            <p><b>Prix de vente</b> {{ $item->prix_vente }} DH</p>
                                                            <p><b>Description : </b>{{ $item->designation_l }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Fermer
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- fin Modal (pour afficher les details de chaque article) --}}

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="row" align="center">
                                    <button {!! setPopOver("Valider l'ajout","Cliquez ici pour valider la création du stock avec l'ensemble des articles choisi") !!} formtarget="_blank"
                                            type="submit" name="submit" value="valider" class="btn btn-default">Valider
                                    </button>
                                </div>

                            </form>
                            {{-- *************** end form ***************** --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('menu_1') @include('Espace_Magas._nav_menu_1') @endsection
@section('menu_2') @include('Espace_Magas._nav_menu_2') @endsection

@section('styles')
    <link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="{{  asset('table2/datatables.min.js') }}"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function () {
                var title = $(this).text();
                if (title == "numero" || title == "code") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title == "Designation") {
                    $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title == "Taille" || title == "Sexe" || title == "Prix d'achat" || title == "Prix de vente") {
                    $(this).html('<input type="text" size="3" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title == "Couleur") {
                    $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title != "") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
            });

            var table = $('#example').DataTable({
                //"scrollY": "50px",
                //"scrollX": true,
                "searching": true,
                "paging": true,
                //"autoWidth": true,
                "info": true,
                stateSave: false,
                "columnDefs": [
                    {"width": "02%", "targets": 0, "visible": true},
                    {"width": "05%", "targets": 1, "visible": false},
                    {"width": "07%", "targets": 2, "visible": false},
                    {"width": "03%", "targets": 3, "visible": true},
                    {"width": "06%", "targets": 4, "visible": false},
                    {"width": "06%", "targets": 5, "visible": false},
                    {"width": "05%", "targets": 6, "visible": false},
                    {"width": "02%", "targets": 7, "visible": false},
                    {"width": "10%", "targets": 8, "visible": false},
                    {"width": "09%", "targets": 9, "visible": false},
                    {"width": "09%", "targets": 10, "visible": false}
                ]
            });

            $('a.toggle-vis').on('click', function (e) {
                e.preventDefault();
                var column = table.column($(this).attr('data-column'));
                column.visible(!column.visible());
            });

            table.columns().every(function () {
                var that = this;
                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
            });
        });

        //script pour le popover detail
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover();
        });
    </script>
@endsection