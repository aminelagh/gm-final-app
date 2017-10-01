@extends('layouts.main_master')

@section('title') Liste promotions  @endsection

@section('main_content')

    <h3 class="page-header">Promotions du magasin
        <strong></strong></h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('vend.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Liste des promotions</li>
    </ol>



    <div class="row">
        @if( !$data->isEmpty() )
            <div class="breadcrumb">
                Afficher/Masquer:
                <a class="toggle-vis" data-column="0">Reference</a> -
                <a class="toggle-vis" data-column="1">Code</a> -
                <a class="toggle-vis" data-column="2">Article</a> -
                <a class="toggle-vis" data-column="3">Marque</a> -
                <a class="toggle-vis" data-column="4">Categorie</a> -
            </div>
        @endif
    </div>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>

                        <th  >Reference</th>
                        <th  >Code</th>
                        <th  >Article</th>
                        <th  >Marque</th>
                        <th  >Categorie</th>
                        <th >Taux de promotion</th>

                        <th  >Etat de promotion</th>
                        <th  >Detais</th>

                    </tr>

                    </thead>
                    <tfoot>
                    <tr>

                        <th>Reference</th>
                        <th>Code</th>
                        <th>Article</th>
                        <th>Marque</th>
                        <th>Categorie</th>
                        <th>Taux</th>
                        <th>Etat promo</th>
                        <th></th>

                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach( $data as $item )
                        <tr >


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
                            <td>{{ \App\Models\Article::getMarque($item->id_article) }}</td>
                            <td>{{ \App\Models\Article::getCategorie($item->id_article) }}</td>
                            <td align="left">{{ \App\Models\Promotion::getTaux($item->id_promotion) }} %</td>

                            <td align="center">
                                @if(\App\Models\Promotion::hasPromotion($item->id_article) == false)
                                    <div id="circle" style="background: darkred;" {!! setPopOver("Promotion","Indisponible") !!}></div>
                                @elseif(\App\Models\Promotion::hasPromotion($item->id_article) == true)
                                    <div id="circle"
                                         style="background: green;" {!! setPopOver("Promotion","Disponible") !!}></div>
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
                                            <b>Detail de la promotion</b></h3>
                                    </div>
                                    <div class="modal-body">

                                        {{-- Date debut --}}
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-4">
                                                <li>Date de debut</li>
                                            </div>
                                            <div class="col-md-6">
                                                <b>{{getDateHelper( \App\Models\Promotion::getDateDebut($item->id_promotion)) }}</b>
                                            </div>
                                        </div>
                                        {{-- Date Fin --}}
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-4">
                                                <li>Date de Fin</li>
                                            </div>
                                            <div class="col-md-6">
                                                <b>{{getDateHelper( \App\Models\Promotion::getDateFin($item->id_promotion)) }}</b>
                                            </div>
                                        </div>

                                        {{-- Prix HT --}}
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-4">
                                                <li>Prix de vente HT  :    </li>
                                            </div>
                                            <div class="col-md-6">
                                              <b>{{ \App\Models\Article::getPrixHT($item->id_article) }} DH</b>
                                            </div>
                                        </div>
                                        {{-- Prix TTC --}}
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-4">
                                                <li>Prix de vente TTC  :    </li>
                                            </div>
                                            <div class="col-md-6">
                                              <b>{{ \App\Models\Article::getPrixTTC($item->id_article) }} DH</b>
                                            </div>
                                        </div>

                                        {{-- Taux de promotion --}}
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-4">
                                                <li>Taux de promotion : </li>
                                            </div>
                                            <div class="col-md-6">
                                              <b> {{ \App\Models\Promotion::getTaux($item->id_promotion) }} %</b>
                                            </div>
                                        </div>


                                        {{-- Prix de promotion --}}
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-4">
                                                <li>Prix de promotion : </li>
                                            </div>
                                            <div class="col-md-6">
                                              <b>{{ \App\Models\Article::getPrixTTC($item->id_article)- (\App\Models\Article::getPrixTTC($item->id_article)*(\App\Models\Promotion::getTaux($item->id_promotion)/100)) }} DH</b>
                                            </div>
                                        </div>
                                        {{-- Etat de promotion --}}
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-4">
                                                <li>Etat de promotion : </li>
                                            </div>
                                            <div class="col-md-6">
                                              @if(\App\Models\Promotion::hasPromotion($item->id_article) == false)
                                                  <b>Indisponible</b>
                                              @elseif(\App\Models\Promotion::hasPromotion($item->id_article) == true)
                                                <b>Disponible</b>
                                              @endif
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer
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

                        {"searchable": false, "orderable": false, "targets": 0, "width":"10%"},
                        //{"width": "04%", "targets": 0, "type": "num", "visible": true, "searchable": false}, //#
                        {"width": "10%", "targets": 1, "type": "string", "visible": true},  //ref
                        {"width": "30%", "targets": 2, "type": "string", "visible": true},  //code

                        //{"width": "08%", "targets": 3, "type": "string", "visible": true},    //desi
                        {"width": "08%", "targets": 3, "type": "string", "visible": true},     //Marque
                        {"width": "20%", "targets": 4, "type": "string", "visible": false},     //caegorie

                        {"width": "20%", "targets": 5, "type": "string", "visible": true},      //HT


                        {"width": "10%", "targets": 6, "type": "num-fmt", "visible": true},     //etat

                        {"width": "10%", "targets": 7, "type": "num-fmt", "visible": true, "searchable": false}
                    ],
                    "select": {
                        items: 'column'
                    }
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
                        $(this).html('<input type="text" size="6" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Categorie" || title == "Marque") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Article") {
                        $(this).html('<input type="text" size="40" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Taux") {
                        $(this).html('<input type="text" size="6" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
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
