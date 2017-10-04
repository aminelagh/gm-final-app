@extends('layouts.main_master')

@section('title') Transfert  de {{ $magasin_source->libelle }} vers {{ $magasin_destination->libelle }} @endsection

@section('main_content')

    <h3 class="page-header">Transfert de stock de <b>{{ $magasin_source->libelle }}</b> vers <b>{{ $magasin_destination->libelle }}</b></h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des magasins</li>
        <li class="breadcrumb-item"><a href="{{ route('magas.magasin',[$magasin_source->id_magasin]) }}">{{ $magasin_source->libelle  }}</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('magas.stocks',[$magasin_source->id_magasin]) }}">Stock</a></li>
        <li class="breadcrumb-item active">Transfert de stock</li>
    </ol>

    <div class="row">
        @if( !$data->isEmpty() )
            <div class="breadcrumb">
                Afficher/Masquer:
                <a class="toggle-vis" data-column="0">Reference</a> -
                <a class="toggle-vis" data-column="1">Code</a> -
                <a class="toggle-vis" data-column="2">Désignation</a> -
                <a class="toggle-vis" data-column="3">Marque</a> -
                <a class="toggle-vis" data-column="4">Categorie</a>
            </div>
        @endif
    </div>

    <script>
        function calcQ(groupe, cpt) {
            var total = 0;
            var prix = document.getElementById("prix_" + groupe).title;
            //var prix = document.getElementById("prix_" +groupe);
            //alert("Prix = "+prix);
            for (i = 1; i <= cpt; i++) {
                var qi = document.getElementById("quantite_" + groupe + "_" + i).value;
                //alert("QI = "+qi);
                if (qi == "") {
                    qi = 0;
                } else if (qi < 0) {
                    //alert("Erreur, q<0");
                    break;
                }
                total += parseInt(qi);
            }
            //alert("total = "+total);
            document.getElementById("sommeQ_" + groupe).value = total;
            document.getElementById("total_" + groupe).value = total * parseFloat(prix);

            calcTotal2();
        }

        function calcTotal2() {
            var total = 0;

            for (j = 1; j < 20; j++) {
                var totali = document.getElementById("total_" + j).value;
                if (document.getElementById("total_" + j).value == "") {
                    totali = 0;
                }
                total = total + parseFloat(totali);
                document.getElementById("total_prix").value = total;
            }
            alert("total= ");
        }

        function calcTotal(counter) {
            var total = 0;
            for (j = 1; j < 100; j++) {
                var totali = document.getElementById("total_" + j).value;

                if (totali == "") {
                    totali = 0;
                } else if (totali < 0) {
                    alert("Erreur, totali<0");
                    break;
                }
                total = total + parseFloat(totali);
                document.getElementById("total_prix").value = total;
                alert("total= " + total);
            }
            document.getElementById("total_prix").value = total;
        }

        function appliquerRemise() {
            var taux = document.getElementById("taux_remise").value;
            var total = document.getElementById("total_prix").value;

            document.getElementById("montant").value = total - total * taux / 100;

        }
    </script>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                {{-- *************** form ***************** --}}
                <form role="form" name="myForm" id="myForm" method="post"
                      action="{{ Route('magas.submitAddStockTransfertOUT') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_magasin_source" value="{{ $magasin_source->id_magasin }}"/>
                    <input type="hidden" name="id_magasin_destination" value="{{ $magasin_destination->id_magasin }}"/>

                    <table id="myTable" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th rowspan="2">Reference</th>
                            <th rowspan="2">Code</th>
                            <th rowspan="2">Désignation</th>
                            <th rowspan="2">Marque</th>
                            <th rowspan="2">Categorie</th>
                            <th colspan="2">Prix de gros</th>
                            <th colspan="2">Prix</th>
                            <th rowspan="2">Etat</th>
                            <th rowspan="2"></th>

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
                            <th>Désignation</th>
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

                            <tr>
                                <input type="hidden" name="id_stock[{{ $loop->iteration }}]" value="{{ $item->id_stock }}"/>
                                <td>
                                    {{ $item->ref }} {{ $item->alias!=null ? ' - '.$item->alias:' ' }}
                                </td>
                                <td>{{ $item->code }}</td>
                                <td>
                                    @if( $item->image != null)
                                        <img src="{{ asset($item->image) }}" width="40px"
                                             onmouseover="overImage('{{ asset($item->image) }}');" onmouseout="outImage();">
                                    @endif
                                    {{ $item->designation }}
                                </td>
                                <td>{{ $item->libelle_m }}</td>
                                <td>{{ $item->libelle_c }}</td>
                                <td align="right">{{ \App\Models\Article::getPrixHT($item->id_article) }}</td>
                                <td align="right">
                                    <div id="prix_{{ $loop->iteration }}"
                                         title="{{ \App\Models\Article::getPrixTTC($item->id_article) }}">{{ \App\Models\Article::getPrixTTC($item->id_article) }}</div>
                                </td>
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
                                    <div class="btn btn-outline btn-success" data-toggle="modal"
                                         data-target="#modal{{ $loop->index+1 }}">Tailles
                                    </div>
                                    {{-- Modal (pour afficher les details de chaque article) --}}
                                    <div class="modal fade" id="modal{{ $loop->index+1 }}" role="dialog"
                                         tabindex="-1" aria-labelledby="gridSystemModalLabel">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                    <h3 class="modal-title" id="gridSystemModalLabel">
                                                        <b>{{ \App\Models\Article::getDesignation($item->id_article) }}</b>
                                                    </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        {{-- detail article --}}
                                                        <div class="col-lg-6">
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
                                                                    <td>Prix de vente</td>
                                                                    <th>{{ \App\Models\Article::getPrixHT($item->id_article) }} Dhs HT
                                                                    </th>
                                                                    <th>
                                                                        {{ \App\Models\Article::getPrixTTC($item->id_article) }} Dhs TTC
                                                                    </th>
                                                                </tr>
                                                            </table>
                                                        </div>

                                                        {{-- tailles & quantotes --}}
                                                        <div class="col-lg-6">
                                                            @if(\App\Models\Stock_taille::hasTailles($item->id_stock))
                                                                <table class="table table-striped table-bordered table-hover">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Taille</th>
                                                                        <th>Quantite disponible</th>
                                                                        <th>Quantite</th>
                                                                    </tr>
                                                                    </thead>
                                                                    @foreach( \App\Models\Stock_taille::getTailles($item->id_stock) as $taille )
                                                                        <tr>
                                                                            <input type="hidden"
                                                                                   name="quantite[{{ $item->id_stock }}][{{ $loop->iteration }}]"
                                                                                   value="{{ $taille->quantite }}"/>
                                                                            <input type="hidden"
                                                                                   name="id_taille_article[{{ $item->id_stock }}][{{ $loop->index+1 }}]"
                                                                                   value="{{ $taille->id_taille_article }}"/>

                                                                            <td align="center">{{ \App\Models\Taille_article::getTaille($taille->id_taille_article) }}</td>
                                                                            <td align="center">{{ $taille->quantite }}</td>
                                                                            <td>
                                                                                <input type="number" min="0" class="form-control"
                                                                                       max="{{ $taille->quantite }}" placeholder="Quantite"
                                                                                       name="quantiteOUT[{{ $item->id_stock }}][{{ $loop->iteration }}]"
                                                                                       value="{{ old('quantiteOUT.'.($item->id_stock).'.'.($loop->iteration).'') }}"
                                                                                       id="quantite_{{ $loop->parent->iteration }}_{{ $loop->iteration }}"
                                                                                       onkeyup="calcQ( 0{{ $loop->parent->iteration }} , 0{{ \App\Models\Stock_taille::getTailles($item->id_stock)->count() }} );">

                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <th colspan="2">Quantité</th>
                                                                        <td><input type="number" readonly class="form-control"
                                                                                   id="sommeQ_{{ $loop->iteration }}" value="0"></td>
                                                                    </tr>

                                                                </table>
                                                            @else
                                                                <h2 class="row">
                                                                    <b><i>Aucun article disponible</i></b>

                                                                    <input type="hidden" name="result" pattern=".##" readonly value="0"
                                                                           id="total_{{ $loop->iteration }}" class="form-control"/>

                                                                </h2>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                    </div>
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

                    <div class="row">
                        <input type="submit" value="Valider" class="btn btn-primary center-block">
                    </div>
                </form>

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
                // Setup - add a text input to each footer cell
                $('#myTable tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Reference" || title == "Code") {
                        $(this).html('<input type="text" size="10" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Categorie" || title == "Marque") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Designation") {
                        $(this).html('<input type="text" size="10" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "HT" || title == "TTC") {
                        $(this).html('<input type="text" size="2" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Prix d'achat" || title == "Prix de vente") {
                        $(this).html('<input type="text" size="4" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                });


                var table = $('#myTable').DataTable({
                    "lengthMenu": [[10, 20, 30, 50, -1], [10, 20, 30, 50, "Tout"]],
                    "searching": true,
                    "paging": true,
                    "info": false,
                    stateSave: false,
                    "columnDefs": [
                        //{"visible": true, "targets": -1},
                        {"width": "04%", "targets": 0, "type": "num", "visible": true, "searchable": false}, //#
                        {"width": "05%", "targets": 1, "type": "string", "visible": true},  //ref
                        //{"width": "05%", "targets": 2, "type": "string", "visible": true},  //code

                        {"width": "05%", "targets": 3, "type": "string", "visible": false},    //desi
                        {"width": "08%", "targets": 4, "type": "string", "visible": false},     //Marque
                        {"width": "08%", "targets": 5, "type": "string", "visible": false},     //caegorie

                        {"width": "02%", "targets": 6, "type": "string", "visible": true},      //HT
                        {"width": "02%", "targets": 7, "type": "num-fmt", "visible": true},     //TTC
                        {"width": "02%", "targets": 8, "type": "string", "visible": true},      //HT
                        {"width": "02%", "targets": 9, "type": "num-fmt", "visible": true},     //TTC

                        //{"width": "05%", "targets": 10, "type": "num-fmt", "visible": true},     //etat

                        {"width": "04%", "targets": 10, "type": "num-fmt", "visible": true, "searchable": false}
                    ],
                    "select": {
                        items: 'column'
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
