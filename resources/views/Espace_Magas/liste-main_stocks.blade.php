@extends('layouts.main_master')

@section('title') {{ $magasin->libelle }}  @endsection

@section('main_content')

    <h3 class="page-header">Stock du magasin principal:
        <strong>{{ $magasin->libelle }}</strong></h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des magasins</li>
        <li class="breadcrumb-item"><a href="{{ route('magas.magasin') }}">{{ $magasin->libelle  }}</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('magas.stocks') }}">Stock</a></li>
    </ol>

    <div class="row" align="center">
        <a type="button" class="btn btn-outline btn-primary" href="{{ Route('magas.addStockIN') }}">
            <i class="glyphicon glyphicon-arrow-down"></i> Entrée de stock</a>
        <a type="button" class="btn btn-outline btn-primary" href="{{ Route('magas.addStockTransfertOUT') }}">
            Transfert</a>
        <a type="button" class="btn btn-outline btn-primary" href="{{ Route('magas.addStockOUT') }}">
            Sortie de stock <i class="glyphicon glyphicon-arrow-up"></i> </a>
    </div>

    <div class="row">
        @if( !$data->isEmpty() )
            <div class="breadcrumb">
                Afficher/Masquer:
                <a class="toggle-vis" data-column="0">Reference</a> -
                <a class="toggle-vis" data-column="1">Code</a> -
                <a class="toggle-vis" data-column="2">Designation</a> -
                <a class="toggle-vis" data-column="3">Marque</a> -
                <a class="toggle-vis" data-column="4">Categorie</a>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th rowspan="2">Reference</th>
                        <th rowspan="2">Code</th>
                        <th rowspan="2">Designation</th>
                        <th rowspan="2">Marque</th>
                        <th rowspan="2">Categorie</th>
                        <th colspan="2">Prix de gros</th>
                        <th colspan="2">Prix</th>
                        <th rowspan="2">Etat</th>
                        <th rowspan="2">Details</th>
                    </tr>
                    <tr>
                        <th>HT</th>
                        <th>TTC</th>
                        <th>HT</th>
                        <th>TTC</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Reference</th>
                        <th>Code</th>
                        <th>Designation</th>
                        <th>Marque</th>
                        <th>Categorie</th>
                        <th>HT</th>
                        <th>TTC</th>
                        <th>HT</th>
                        <th>TTC</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach( $data as $item )
                        <tr ondblclick="window.open('{{ Route('magas.stock',[ 'p_id' => $item->id_stock ]) }}');">
                            <td>
                                {{ $item->ref }}
                                {{ $item->alias!=null ? ' - '.$item->alias:' ' }}
                            </td>
                            <td>{{ $item->code }}</td>
                            <td>
                                @if( $item->image != null) <img src="{{ asset($item->image) }}" width="40px">@endif
                                {{ $item->designation }}
                            </td>
                            <td>{{ $item->libelle_m }}</td>
                            <td>{{ $item->libelle_c }}</td>
                            <td align="right">{{ \App\Models\Article::getPrixHT($item->id_article) }}</td>
                            <td align="right">{{ \App\Models\Article::getPrixTTC($item->id_article) }}</td>
                            <td align="right">{{ \App\Models\Article::getPrixHT($item->id_article) }}</td>
                            <td align="right">{{ \App\Models\Article::getPrixTTC($item->id_article) }}</td>
                            <td align="center">
                                @if(\App\Models\Stock::getState($item->id_stock) == 0)
                                    <div id="circle"
                                         style="background: darkred;" {!! setPopOver("indisponible",\App\Models\Stock::getNombreArticles($item->id_stock)." article") !!}></div>
                                @elseif(\App\Models\Stock::getState($item->id_stock) == 1)
                                    <div id="circle"
                                         style="background: red;" {!! setPopOver("",\App\Models\Stock::getNombreArticles($item->id_stock)." article(s)") !!}></div>
                                @elseif(\App\Models\Stock::getState($item->id_stock) == 2)
                                    <div id="circle"
                                         style="background: orange;" {!! setPopOver("",\App\Models\Stock::getNombreArticles($item->id_stock)." article(s)") !!}></div>
                                @elseif(\App\Models\Stock::getState($item->id_stock) == 3)
                                    <div id="circle"
                                         style="background: lawngreen;" {!! setPopOver("Disponible",\App\Models\Stock::getNombreArticles($item->id_stock)." article(s)") !!}></div>
                                @endif
                            </td>
                            <td align="center">
                                <a data-toggle="modal" data-target="#modal{{ $loop->iteration }}"><i
                                            class="glyphicon glyphicon-info-sign"
                                            aria-hidden="false"></i></a>

                                {{-- Modal (pour afficher les details de chaque article) --}}
                                <div class="modal fade" id="modal{{ $loop->iteration }}" role="dialog"
                                     tabindex="-1" aria-labelledby="gridSystemModalLabel">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                            aria-hidden="true">&times;</span></button>
                                                <h3 class="modal-title" id="gridSystemModalLabel">
                                                    <b>{{ \App\Models\Article::getDesignation($item->id_article) }}</b>
                                                </h3>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <table class="table table-striped table-bordered table-hover">
                                                            <tr>
                                                                <td>Reference</td>
                                                                <th>{{ $item->ref }}
                                                                    {{ $item->alias!=null ? ' - '.$item->alias:' ' }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Code</td>
                                                                <th>{{ $item->code }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Marque</td>
                                                                <th>{{ $item->libelle_m  }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Categorie</td>
                                                                <th>{{ $item->libelle_c }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Fournisseur</td>
                                                                <th>{{ $item->libelle_f }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Couleur</td>
                                                                <th>{{ $item->couleur }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Sexe</td>
                                                                <th>{{ $item->sexe }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" align="center">Prix de vente</td>
                                                            </tr>
                                                            <tr>
                                                                <th align="right">{{ \App\Models\Article::getPrixHT($item->id_article) }}
                                                                    Dhs HT
                                                                </th>
                                                                <th>{{ \App\Models\Article::getPrixTTC($item->id_article) }}
                                                                    Dhs TTC
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" align="center">Prix de gros</td>
                                                            </tr>
                                                            <tr>
                                                                <th align="right">{{ \App\Models\Article::getPrixGrosHT($item->id_article) }}
                                                                    Dhs HT
                                                                </th>
                                                                <th>{{ \App\Models\Article::getPrixGrosTTC($item->id_article) }}
                                                                    Dhs TTC
                                                                </th>
                                                            </tr>
                                                        </table>
                                                        @if( \App\Models\Article::getImage($item->id_article) != null)
                                                            <img src="{{ asset(\App\Models\Article::getImage($item->id_article)) }}"
                                                                 width="150px">
                                                        @endif
                                                    </div>
                                                    @if(\App\Models\Stock_taille::hasTailles($item->id_stock))
                                                        <div class="col-lg-6">
                                                            <table class="table table-striped table-bordered table-hover">
                                                                <thead>
                                                                <tr>
                                                                    <th>Taille</th>
                                                                    <th align="right">Quantite</th>
                                                                </tr>
                                                                </thead>

                                                                @foreach(\App\Models\Stock_taille::getTailles($item->id_stock) as $taille)
                                                                    <tr>
                                                                        <td>{{ \App\Models\Taille_article::getTaille($taille->id_taille_article) }}</td>
                                                                        <td align="right">{{ $taille->quantite }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    @else
                                                        <div class="col-lg-6">
                                                            <h2>Auncune taille</h2>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- fin Modal (pour afficher les details de chaque article) --}}
                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <br/>

    <hr/>
    <br/>
@endsection

@section('scripts')
    @if(!$data->isEmpty())
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function () {
                var table = $('#myTable').DataTable({
                    "lengthMenu": [[10, 20, 30, 50, -1], [10, 20, 30, 50, "Tout"]],
                    "searching": true,
                    "paging": true,
                    "info": true,
                    stateSave: false,
                    "columnDefs": [
                        {"width": "03%", "targets": 0, "type": "num", "visible": true}, //#
                        {"width": "03%", "targets": 1, "type": "string", "visible": true},  //ref
                        {"width": "05%", "targets": 2, "type": "string", "visible": true},  //code

                        //{"width": "08%", "targets": 3, "type": "string", "visible": true},    //desi
                        {"width": "05%", "targets": 3, "type": "string", "visible": true},     //Marque
                        {"width": "05%", "targets": 4, "type": "string", "visible": true},     //caegorie

                        {"width": "01%", "targets": 5, "type": "string", "visible": true},      //HT
                        {"width": "01%", "targets": 6, "type": "num-fmt", "visible": true},     //TTC
                        {"width": "01%", "targets": 7, "type": "string", "visible": true},      //HT
                        {"width": "01%", "targets": 8, "type": "num-fmt", "visible": true},     //TTC

                        {"width": "01%", "targets": 9, "type": "num-fmt", "visible": true},     //etat

                        {"width": "01%", "targets": 10, "type": "num-fmt", "visible": true, "searchable": false}
                    ]
                });

                // table.on('order.dt search.dt', function () {
                //     table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                //         cell.innerHTML = i + 1;
                //     });
                // }).draw();

                // Setup - add a text input to each footer cell
                $('#myTable tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Reference" || title == "Code") {
                        $(this).html('<input type="text" size="8" class="form-control input-md" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Categorie" || title == "Marque") {
                        $(this).html('<input type="text" size="6" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Designation") {
                        $(this).html('<input type="text" size="10" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "HT" || title == "TTC") {
                        $(this).html('<input type="text" size="1" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Prix d'achat") {
                        $(this).html('<input type="text" size="4" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
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

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection

@section('styles')
    <style>
        #circle {
            width: 15px;
            height: 15px;
            -webkit-border-radius: 25px;
            -moz-border-radius: 25px;
            border-radius: 25px;
        }

        #myTable {
            width: 100%;
            border: 0px solid #D9D5BE;
            border-collapse: collapse;
            margin: 0px;
            background: white;
            font-size: 1em;
        }

        #myTable td {
            padding: 5px;
        }
    </style>
@endsection
