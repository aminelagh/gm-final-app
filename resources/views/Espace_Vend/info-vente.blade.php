@extends('layouts.main_master')

@section('title')  Detail de vente @endsection

@section('main_content')

    <h3 class="page-header">Detail de la vente</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des ventes</li>
        <li class="breadcrumb-item "><a href="{{ route('vend.ventes') }}">Liste des ventes</a></li>
        <li class="breadcrumb-item active">Detail de la vente  </li>

    </ol>


        <div class="row">
            @if( !$data->isEmpty() )
                <div class="breadcrumb">
                    Afficher/Masquer:
                    <a class="toggle-vis" data-column="1">Reference</a> -
                    <a class="toggle-vis" data-column="2">Code</a> -
                    <a class="toggle-vis" data-column="3">Designation</a> -
                    <a class="toggle-vis" data-column="6">Marque</a> -
                    <a class="toggle-vis" data-column="7">Categorie</a> -
                </div>
            @endif
        </div>

        <div class="row">
            <div class="table-responsive">
                <div class="col-lg-12">
                    <table id="myTable" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Reference</th>
                            <th rowspan="2">Code</th>
                            <th rowspan="2">Designation</th>
                            <th rowspan="2">Taille</th>
                            <th rowspan="2">Quantite</th>
                            <th rowspan="2">Marque</th>
                            <th rowspan="2">Categorie</th>

                            <th colspan="2">Prix de vente</th>
                            <th rowspan="2">Prix en promotion</th>

                            <th rowspan="2">Actions</th>

                        </tr>
                        <tr>
                            <th>HT</th>
                            <th>TTC</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Reference</th>
                            <th>Code</th>
                            <th>Designation</th>
                            <th>Taille</th>
                            <th>Quantite</th>
                            <th>Marque</th>
                            <th>Categorie</th>
                            <th>HT</th>
                            <th>TTC</th>

                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach( $data as $item )
                            <tr >

                                <td></td>
                                <td>
                                    {{ \App\Models\Article::getRef($item->id_article) }}
                                    {{ \App\Models\Article::getAlias($item->id_article)!=null ? ' - '.\App\Models\Article::getAlias($item->id_article):' ' }}
                                </td>
                                <td>{{ \App\Models\Article::getCode($item->id_article) }}</td>
                                <td>
                                    @if( App\Models\Article::getImage($item->id_article) != null) <img
                                            src="{{ asset(App\Models\Article::getImage($item->id_article)) }}"
                                            width="40px">@endif
                                    {{ \App\Models\Article::getDesignation($item->id_article) }}
                                </td>
                                <td>{{ \App\Models\Vente_article::getTaille($item->id_taille_article) }} </td>
                                <td>{{ \App\Models\Vente_article::getQuantite($item->id_vente_article) }} </td>
                                <td>{{ \App\Models\Article::getMarque($item->id_article) }}</td>
                                <td>{{ \App\Models\Article::getCategorie($item->id_article) }}</td>
                                <td align="right">{{ \App\Models\Article::getPrixHT($item->id_article) }} DH</td>
                                <td align="right">{{ \App\Models\Article::getPrixTTC($item->id_article) }} DH</td>
                                <td align="right">
@if(\App\Models\Promotion::hasPromotion($item->id_article) == true)
                                      <b>{{ \App\Models\Promotion::getPrixPromotion($item->id_article)}} DH</b>
@elseif(\App\Models\Promotion::hasPromotion($item->id_article) == false)
Indisponible
@endif




                                </td>


                                <td align="center">
                                    <a data-toggle="modal" data-target="#modal{{ $loop->index+1 }}"><i
                                                class="glyphicon glyphicon-info-sign"
                                                aria-hidden="false"></i></a>
                                </td>
                            </tr>

                            {{-- Modal (pour afficher les details de chaque article) --}}
                            <div class="modal fade" id="modal{{ $loop->index+1 }}" role="dialog"
                                 tabindex="-1" aria-labelledby="gridSystemModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span
                                                        aria-hidden="true">&times;</span></button>
                                            <h3 class="modal-title" id="gridSystemModalLabel">
                                                <b>{{ \App\Models\Article::getDesignation($item->id_article) }}</b></h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-4">
                                                    <li>Code</li>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>{{ \App\Models\Article::getCode($item->id_article) }}</b>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-4">
                                                    <li>Reference</li>
                                                </div>
                                                <div class="col-md-6"><b>
                                                        {{ \App\Models\Article::getRef($item->id_article) }}
                                                        {{ \App\Models\Article::getAlias($item->id_article)!=null ? ' - '.\App\Models\Article::getAlias($item->id_article):' ' }}
                                                    </b>
                                                </div>
                                            </div>
                                            {{-- marque --}}
                                            <div class="row">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-4">
                                                    <li>Marque</li>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>{{ \App\Models\Article::getMarque($item->id_article) }}</b>
                                                </div>
                                            </div>
                                            {{-- categorie --}}
                                            <div class="row">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-4">
                                                    <li>Categorie</li>
                                                </div>
                                                <div class="col-lg-6">
                                                    <b>{{ \App\Models\Article::getCategorie($item->id_article) }}</b>
                                                </div>
                                            </div>
                                            {{-- fournisseur --}}
                                            <div class="row">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-4">
                                                    <li>Fournisseur</li>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>{{ \App\Models\Article::getFournisseur($item->id_article) }}</b>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <hr/>
                                            </div>

                                            {{-- couleur --}}
                                            <div class="row">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-4">
                                                    <li>Couleur</li>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>{{ \App\Models\Article::getCouleur($item->id_article) }}</b>
                                                </div>
                                            </div>
                                            {{-- sexe --}}
                                            <div class="row">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-4">
                                                    <li>Sexe</li>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>{{ \App\Models\Article::getSexe($item->id_article) }}</b>
                                                </div>
                                            </div>

                                            {{-- Taille --}}
                                            <div class="row">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-4">
                                                    <li>Taille</li>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>{{ \App\Models\Vente_article::getTaille($item->id_taille_article) }}</b>
                                                </div>
                                            </div>

                                            {{-- Quantité --}}
                                            <div class="row">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-4">
                                                    <li>Quantite</li>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>{{ \App\Models\Vente_article::getQuantite($item->id_vente_article) }}</b>
                                                </div>
                                            </div>

                                            {{-- Prix de gros --}}
                                            <div class="row">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-4">
                                                    <li>Prix de gros</li>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3"></div>
                                                <div class="col-md-1">HT</div>
                                                <div class="col-md-3">
                                                    <b>{{ \App\Models\Article::getPrixGrosHT($item->id_article) }} DH</b>
                                                </div>
                                                <div class="col-md-1">TTC</div>
                                                <div class="col-md-3">
                                                    <b>{{ \App\Models\Article::getPrixGrosTTC($item->id_article) }} DH</b>
                                                </div>
                                            </div>
                                            {{-- Prix --}}
                                            <div class="row">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-4">
                                                    <li>Prix Unitaire</li>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3"></div>
                                                <div class="col-md-1">HT</div>
                                                <div class="col-md-3">
                                                    <b>{{ \App\Models\Article::getPrixHT($item->id_article) }} DH</b>
                                                </div>
                                                <div class="col-md-1">TTC</div>
                                                <div class="col-md-3">
                                                    <b>{{ \App\Models\Article::getPrixTTC($item->id_article) }} DH</b>
                                                </div>
                                            </div>
                                            {{-- Prix de promotion --}}
                                            <div class="row">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-4">
                                                    <li>Prix De promotion : </li>
                                                </div>




                                                <div class="col-md-6">
                                                  @if(\App\Models\Promotion::hasPromotion($item->id_article) == true)
                                                                                        <b>{{ \App\Models\Promotion::getPrixPromotion($item->id_article)}} DH</b>
                                                  @elseif(\App\Models\Promotion::hasPromotion($item->id_article) == false)
                                                  Indisponible
                                                  @endif
                                                </div>

                                            </div>


                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- fin Modal (pour afficher les details de chaque article) --}}
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
                        //"autoWidth": true,
                        "info": false,
                        stateSave: false,
                        "columnDefs": [
                            {"visible": true, "targets": -1},

                            {"searchable": false, "orderable": false, "targets": 0},
                            //{"width": "04%", "targets": 0, "type": "num", "visible": true, "searchable": false}, //#
                            {"width": "05%", "targets": 1, "type": "string", "visible": true},  //ref
                            {"width": "05%", "targets": 2, "type": "string", "visible": false},  //code

                            {"width": "08%", "targets": 3, "type": "string", "visible": true},    //desi
                            {"width": "08%", "targets": 4, "type": "string", "visible": true},     //Marque
                            {"width": "08%", "targets": 5, "type": "string", "visible": true},     //caegorie

                            {"width": "02%", "targets": 6, "type": "string", "visible": false},      //HT
                            {"width": "02%", "targets": 7, "type": "num-fmt", "visible": false},     //TTC
                            {"width": "02%", "targets": 8, "type": "string", "visible": true},      //HT
                            {"width": "02%", "targets": 9, "type": "num-fmt", "visible": true},     //TTC

                            {"width": "05%", "targets": 10, "type": "num-fmt", "visible": true},     //etat

                            {"width": "04%", "targets": 11, "type": "num-fmt", "visible": true, "searchable": false}
                        ],
                        "select": {
                            items: 'column'
                        }
                    });

                    table.on('order.dt search.dt', function () {
                        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }).draw();

                    // Setup - add a text input to each footer cell
                    $('#myTable tfoot th').each(function () {
                        var title = $(this).text();
                        if (title == "Reference" || title == "Code") {
                            $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                        }
                        else if (title == "Categorie" || title == "Marque") {
                            $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                        }
                        else if (title == "Designation") {
                            $(this).html('<input type="text" size="20" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
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

                    //footer input: hide text
                    $('a.toggle-vis').on('click', function (e) {
                        e.preventDefault();
                        var column = table.column($(this).attr('data-column'));
                        column.visible(!column.visible());
                    });

                    //footer search
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

    @section('menu_1')@include('Espace_Vend._nav_menu_1')@endsection
    @section('menu_2')@include('Espace_Vend._nav_menu_2')@endsection

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
