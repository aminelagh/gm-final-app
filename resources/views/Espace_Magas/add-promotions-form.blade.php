@extends('layouts.main_master')

@section('title') Creation de promotions @endsection

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
                if (title != "") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
                }
                if (title == "numero" || title == "code") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
                }
                if (title == "Designation") {
                    $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
                }
                if (title == "Taille") {
                    $(this).html('<input type="text" size="3" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
                }
                if (title == "Couleur") {
                    $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
                } else {
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
                    {"width": "2%", "targets": 0},
                    {"width": "5%", "targets": 1},
                    {"width": "7%", "targets": 2},
                    {"width": "7%", "targets": 3},
                    {"width": "3%", "targets": 4},
                    //{"width": "6%", "targets": 5},
                    {"width": "6%", "targets": 5},
                    {"width": "5%", "targets": 6},
                    {"width": "3%", "targets": 7},
                    {"width": "8%", "targets": 8},
                    {"width": "8%", "targets": 9},
                    {"width": "3%", "targets": 10}
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

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Création des promotions</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('direct.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a
                                href="{{ Route('direct.lister',['p_table' => 'promotions' ]) }}"> Liste des
                            promotions<</a></li>
                    <li class="breadcrumb-item">Creation des promotions</li>
                </ol>

                {{-- *************** Alerts *************** --}}
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        @if (session('alert_success'))
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button> {!! session('alert_success') !!}
                            </div>
                        @endif
                        @if (session('alert_info'))
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button> {!! session('alert_info') !!}
                            </div>
                        @endif
                        @if (session('alert_warning'))
                            <div class="alert alert-warning alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button> {!! session('alert_warning') !!}
                            </div>
                        @endif
                        @if (session('alert_danger'))
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button> {!! session('alert_danger') !!}
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                {{-- ************** /.Alerts ************** --}}

                <div class="row">
                    <div class="table-responsive">
                        <div class="col-lg-12">
                            <div class="breadcrumb">
                                Afficher/Masquer:
                                <a class="toggle-vis" data-column="0">Categorie</a> -
                                <a class="toggle-vis" data-column="1">Fournisseur</a> -
                                <a class="toggle-vis" data-column="2">Numero</a> -
                                <a class="toggle-vis" data-column="3">Code</a> -
                                <a class="toggle-vis" data-column="4">Designation</a> -
                                <a class="toggle-vis" data-column="5">Prix de vente</a>
                            </div>
                            {{-- *************** form ***************** --}}
                            <form role="form" method="post"
                                  action="{{ Route('direct.submitAdd',[ 'p_table' => 'promotions' ]) }}">
                                {{ csrf_field() }}
                                <table id="example" class="table table-striped table-bordered table-hover">
                                    <thead bgcolor="#DBDAD8">
                                    <tr>
                                        <th>#</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Categorie</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Fournisseur</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Numero</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Code</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Article</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Prix de vente</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Magasin</th>
                                        <th>Taux</th>
                                        <th>Date debut</th>
                                        <th>Date fin</th>
                                        <th>Autres</th>
                                    </tr>
                                    </thead>
                                    <tfoot bgcolor="#DBDAD8">
                                    <tr>
                                        <th></th>
                                        <th>Categorie</th>
                                        <th>Fournisseur</th>
                                        <th>Numero</th>
                                        <th>Code</th>
                                        <th>Article</th>
                                        <th>Prix de vente</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach( $articles as $item )
                                        <tr>
                                            <input type="hidden" name="id_article[{{ $loop->index+1 }}]"
                                                   value="{{ $item->id_article }}">

                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ getChamp('categories', 'id_categorie', $item->id_categorie, 'libelle') }}</td>
                                            <td>{{ getChamp('fournisseurs', 'id_fournisseur', $item->id_fournisseur, 'libelle') }}</td>
                                            <td>{{ $item->num_article }}</td>
                                            <td>{{ $item->code_barre }}</td>
                                            <td>{{ $item->designation_c }}</td>
                                            <td align="right">{{ getTTC($item->prix_vente,2) }}</td>
                                            <td>
                                                <select class="form-control" name="id_magasin[{{ $loop->index+1 }}]">
                                                    <option value="0" selected>Aucun</option>
                                                    @if( !$magasins->isEmpty() )
                                                        @foreach( $magasins as $magasin )
                                                            <option value="{{ $magasin->id_magasin }}">{{ $magasin->libelle }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td><input type="number" min="0" patern=".##" placeholder="Taux"
                                                       name="taux[{{ $loop->index+1 }}]"></td>
                                            <td><input type="date" name="date_debut[{{ $loop->index+1 }}]"
                                                       value="{{ old('date_debut['.($loop->index+1).']') }}"></td>
                                            <td><input type="date" name="date_fin[{{ $loop->index+1 }}]"
                                                       value="{{ old('date_fin['.($loop->index+1).']') }}"></td>
                                            <td>
                                                <button type="button" class="btn btn-info" data-toggle="modal"
                                                        data-target="#modal{{ $loop->index+1 }}">Detail
                                                </button>
                                            </td>

                                            {{-- Modal (pour afficher les details de chaque article) --}}
                                            <div class="modal fade" id="modal{{ $loop->index+1 }}" role="dialog">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                &times;
                                                            </button>
                                                            <h4 class="modal-title">{{ $item->designation_c }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><b>numero</b> {{ $item->num_article }}</p>
                                                            <p><b>code a barres</b> {{ $item->code_barre }}</p>
                                                            <p><b>Taille</b> {{ $item->taille }}</p>
                                                            <p><b>Couleur</b> {{ $item->couleur }}</p>
                                                            <p><b>sexe</b> {{ getSexeName($item->sexe) }}</p>
                                                            <p><b>Prix
                                                                    d'achat</b> {{ number_format($item->prix_achat,2) }}
                                                                Dhs HT,{{ getTTC($item->prix_achat) }} Dhs TTC</p>
                                                            <p><b>Prix de
                                                                    vente</b> {{ number_format($item->prix_vente,2) }}
                                                                Dhs HT,{{ getTTC($item->prix_vente) }} Dhs TTC</p>
                                                            <p>{{ $item->designation_l }}</p>
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
                                    <tr>
                                        <td colspan="12" align="center">
                                            <button formtarget="_blank" data-toggle="popover" data-placement="top"
                                                    data-trigger="hover" title="Valider l'ajout"
                                                    data-content="Cliquez ici pour valider la création des promotions sur l'ensemble des articles choisi"
                                                    type="submit" name="submit" value="valider" class="btn btn-default">
                                                Valider
                                            </button>
                                        </td>
                                    </tr>
                                </table>
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
