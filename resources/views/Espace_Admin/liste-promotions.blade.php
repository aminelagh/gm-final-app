@extends('layouts.main_master')

@section('title') Promotions @endsection

@section('main_content')
    <h3 class="page-header">Promotions</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des promotions</li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.promotions') }}">Liste des promotions</a></li>
    </ol>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="example" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Magasin</th>
                        <th>Article</th>
                        <th>Taux</th>
                        <th>Periode</th>
                        <th>Etat</th>
                        <th>Details</th>
                    </tr>
                    </thead>
                    @if( !$data->isEmpty() )
                        <tfoot>
                        <tr>
                            <th>Magasin</th>
                            <th>Article</th>
                            <th>Taux</th>
                            <th>Periode</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    @endif

                    <tbody>

                    @if( $data->isEmpty() )
                        <tr>
                            <td colspan="6" align="center"><i>Aucune promotion</i></td>
                        </tr>
                    @else
                        @foreach( $data as $item )
                            <tr>
                                <td>
                                    <a href="{{ route('admin.magasin',['p_id'=>$item->id_magasin]) }}" {!! setPopOver("","Details magasin") !!}>{{ $item->libelle }}
                                        <small>({{ $item->ville }})</small>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.article',[ $item->id_article]) }}"> {{ $item->designation }}</a>
                                </td>
                                <td align="right">{{ $item->taux }} %</td>
                                <td align="middle">du <b>{{ getShortDateHelper($item->date_debut) }}</b> au
                                    <b>{{ getDateHelper($item->date_fin) }}</b></td>
                                <td align="middle">
                                    @if($item->active == false)
                                        <div id="circle"
                                             style="background: darkred;" {!! setPopOver(""," Inactive") !!}></div>
                                    @else
                                        <div id="circle"
                                             style="background: greenyellow;" {!! setPopOver("","Active") !!}></div>
                                    @endif
                                </td>
                                <td align="middle">
                                    <a data-toggle="modal"
                                       data-target="#modal{{ $loop->iteration }}" {!! setPopOver("","Details/Modifier/Supprimer") !!}>
                                        <i class="glyphicon glyphicon-info-sign"></i></a>


                                    {{-- Modal (pour afficher les details de chaque article) --}}
                                    <div class="modal fade" id="modal{{ $loop->iteration }}" role="dialog"
                                         tabindex="-1" aria-labelledby="gridSystemModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                    <h3 class="modal-title" id="gridSystemModalLabel">
                                                        <b>{{ $item->designation }}</b>
                                                    </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        <tr>
                                                            <td>Code</td>
                                                            <th colspan="2">{{ $item->code }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Reference</td>
                                                            <th colspan="2">
                                                                {{ $item->ref }}
                                                                {{ $item->alias!=null ? ' - '.$item->alias:' ' }}
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>Marque</td>
                                                            <th colspan="2">{{ $item->libelle_m }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Categorie</td>
                                                            <th colspan="2">{{ $item->libelle_c }}</th>
                                                        </tr>

                                                        <tr>
                                                            <td>Fournisseur</td>
                                                            <th colspan="2">{{ $item->libelle_f }}</th>
                                                        </tr>

                                                        <tr>
                                                            <td>Couleur</td>
                                                            <th colspan="2">{{ $item->couleur }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Sexe</td>
                                                            <th colspan="2">{{ $item->sexe }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Prix d'achat</td>
                                                            <th>{{ number_format($item->prix_a,2) }}
                                                                Dhs HT
                                                            </th>
                                                            <th>
                                                                {{ \App\Models\Article::HTtoTTC($item->prix_a) }}
                                                                Dhs TTC
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>Prix de vente</td>
                                                            <th>{{ number_format($item->prix_v,2) }}
                                                                Dhs HT
                                                            </th>
                                                            <th>
                                                                {{ \App\Models\Article::HTtoTTC($item->prix_v) }}
                                                                Dhs TTC
                                                            </th>
                                                        </tr>
                                                    </table>
                                                    @if($item->image!=null)
                                                        <img src="{{ $item->image }}"
                                                             width="200" hight="200">
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-lg-4">
                                                        <form action="{{ route('admin.deletePromotion',[$item->id_promotion]) }}"
                                                              method="post">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit" class="btn btn-danger btn-outline">
                                                                Supprimer
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <a class="btn btn-info"
                                                           href="{{ route('admin.promotion',['id_promotion'=>$item->id_promotion]) }}">
                                                            Modifier
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">
                                                            Fermer
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- fin Modal (pour afficher les details de chaque article) --}}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <hr>

    <!-- row -->
    <div class="row" align="center">
        <a href="{{ Route('admin.addPromotions') }}" type="button"
           class="btn btn-outline btn-default" {!! setPopOver("","Ajouter de nouvelles promotions") !!}>
            <i class="glyphicon glyphicon-plus "></i> Ajouter des promotions</a>
    </div>


@endsection

@section('scripts')
    @if( !$data->isEmpty() )
        <script>
            $(document).ready(function () {

                // DataTable
                var table = $('#example').DataTable({
                    "lengthMenu": [[10, 20, 30, 50, -1], [10, 20, 30, 50, "Tout"]],
                    "searching": true,
                    "paging": true,
                    "info": true,
                    stateSave: false,
                    "columnDefs": [
                        //{"visible": true, "targets": -1},
                        {"width": "13%", "targets": 0, "searchable": false, "orderable": true,},
                        //{"width": "05%", "targets": 1, "type": "string", "visible": true},
                        {"width": "05%", "targets": 2, "type": "string", "visible": true},

                        {"width": "35%", "targets": 3, "type": "string", "visible": true},
                        {"width": "02%", "targets": 4, "type": "string", "visible": true},
                        {"width": "02%", "targets": 5, "type": "num-fmt", "visible": true, "searchable": false}
                    ],
                    "order": [[1, 'asc']],
                    "select": {items: 'column'}
                });

                /*table.on('order.dt search.dt', function () {
                 table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                 cell.innerHTML = i + 1;
                 });
                 }).draw();*/

                // Setup - add a text input to each footer cell
                $('#example tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Magasin") {
                        $(this).html('<input type="text" size="8" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Article") {
                        $(this).html('<input type="text" size="10" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Taux") {
                        $(this).html('<input type="text" size="1" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Periode") {
                        $(this).html('<input type="text" size="20" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
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
        </script>
    @endif
@endsection

@section('styles')
    <style>
        #circle {
            width: 15px;
            height: 15px;
            -webkit-border-radius: 25px;
            -moz-border-radius: 25px;
            border-radius: 25px;
        }

        #example {
            width: 100%;
            border: 0px solid #D9D5BE;
            border-collapse: collapse;
            margin: 0px;
            background: white;
            font-size: 1em;
        }

        #example td {
            padding: 2px;
        }
    </style>
@endsection

@section('menu_1') @include('Espace_Admin._nav_menu_1') @endsection
@section('menu_2') @include('Espace_Admin._nav_menu_2') @endsection
