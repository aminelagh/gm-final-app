@extends('layouts.main_master')

@section('title') Création des promotions @endsection

@section('main_content')
    <h3 class="page-header">Création des promotions</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des promotions</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.promotions') }}">Nouvelle vente simple</a></li>
        <li class="breadcrumb-item active">Création des promotions</li>
    </ol>

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
        <form role="form" name="myForm" id="myForm" method="post"
              action="{{ Route('admin.submitAddPromotions') }}">
            {{ csrf_field() }}
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
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach( $data as $item )

                            <tr {{--ondblclick="window.open('{{ Route('magas.stock',[ 'p_id' => $item->id_stock ]) }}');" --}}>

                                <input type="hidden" name="id_article[{{ $loop->iteration }}]"
                                       value="{{ $item->id_article }}"/>

                                <td>
                                    {{ $item->ref }}
                                    {{  $item->alias!=null ? ' - '.$item->alias:' ' }}
                                </td>
                                <td>{{  $item->code }}</td>
                                <td>
                                    @if( $item->image != null)
                                        <img src="{{ asset($item->image) }}"
                                             width="40px"
                                             onmouseover="overImage('{{ asset($item->image) }}');"
                                             onmouseout="outImage();">
                                    @endif
                                    {{ $item->designation }}
                                </td>
                                <td>{{ $item->libelle_m }}</td>
                                <td>{{ $item->libelle_c }}</td>
                                <td align="right">{{ number_format($item->prix_v,2) }}</td>
                                <td align="right">{{ \App\Models\Article::HTtoTTC($item->prix_v) }}</td>
                                <td align="right">{{ number_format($item->prix_v,2) }}</td>
                                <td align="right">{{ \App\Models\Article::HTtoTTC($item->prix_v) }}</td>

                                <td align="center">
                                    <div data-toggle="modal" data-target="#modal{{ $loop->iteration }}">
                                        <i class="glyphicon glyphicon-info-sign" {!! setPopOver("Detail","formulaire de la promotion") !!}></i>
                                    </div>

                                    {{-- Modal (pour afficher les details de chaque article) --}}
                                    <div class="modal fade" id="modal{{ $loop->iteration }}" role="dialog"
                                         tabindex="-1" aria-labelledby="gridSystemModalLabel">
                                        <div class="modal-dialog modal-me">
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
                                                    <div class="row">
                                                        {{-- detail article --}}
                                                        <div class="col-lg-12">
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
                                                                    <th>{{ number_format($item->prix_v,2) }}
                                                                        Dhs HT
                                                                    </th>
                                                                    <th>
                                                                        {{ \App\Models\Article::HTtoTTC($item->prix_v) }}
                                                                        Dhs TTC
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Prix de gros</td>
                                                                    <th>{{ number_format($item->prix_v,2) }}
                                                                        Dhs HT
                                                                    </th>
                                                                    <th>
                                                                        {{ \App\Models\Article::HTtoTTC($item->prix_v) }}
                                                                        Dhs TTC
                                                                    </th>
                                                                </tr>
                                                            </table>
                                                            <table class="table table-striped table-bordered table-hover">
                                                                <tr>
                                                                    <th>Taux
                                                                        <i class="glyphicon glyphicon-info-sign" {!! setPopOver("Taux de la promotion","(exemple 15%)") !!}></i>
                                                                    </th>
                                                                    <th>Date debut</th>
                                                                    <th>Date fin</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <input type="number" pattern="##.##"
                                                                                   step="0.01" min="0" max="100"
                                                                                   name="taux[{{ $loop->iteration }}]"
                                                                                   value="{{ old('taux.'.($loop->iteration).'') }}"
                                                                                   class="form-control">
                                                                            <span class="input-group-addon"
                                                                                  id="basic-addon2">%</span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <input type="date" class="form-control"
                                                                               
                                                                               name="date_debut[{{ $loop->iteration }}]"
                                                                               value="{{ old('date_debut.'.($loop->iteration).'') }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="date" class="form-control"
                                                                               
                                                                               name="date_fin[{{ $loop->iteration }}]"
                                                                               value="{{ old('date_fin.'.($loop->iteration).'') }}">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
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

                        </tbody>
                    </table>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-lg-4">
                                <label>Magasin</label>
                                <select class="form-control" name="id_magasin">
                                    @foreach($magasins as $magasin)
                                        <option value="{{ $magasin->id_magasin }}" {{ old('id_magasin') == $magasin->id_magasin ? 'selected' : '' }}>{{ $magasin->libelle }}
                                            <small>({{ $magasin->ville }})</small>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <input type="submit" class="btn btn-primary center-block" value="Valider">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <br/>

    <hr/>
    <br/>
@endsection

@section('scripts')
    @if(!$data->isEmpty())
        <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
        <script>
            (function ($) {
                $.fn.datepicker.dates['fr'] = {
                    days: ["dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"],
                    daysShort: ["dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam."],
                    daysMin: ["di", "lu", "ma", "me", "j", "v", "s"],
                    months: ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"],
                    monthsShort: ["janv.", "févr.", "mars", "avril", "mai", "juin", "juil.", "août", "sept.", "oct.", "nov.", "déc."],
                    today: "Aujourd'hui",
                    monthsTitle: "Mois",
                    clear: "Effacer",
                    weekStart: 1,
                    format: "dd/mm/yyyy"
                };
            }(jQuery));

            $(document).ready(function () {
                var date_input = $('input[id="date"]');
                //var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
                date_input.datepicker({
                    format: 'dd-mm-yyyy',
                    //container: container,
                    todayHighlight: true,
                    autoclose: true,
                    language: 'fr',
                });
            });
        </script>
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
                        {"visible": true, "targets": -1},
                        {"width": "04%", "targets": 0, "type": "num", "visible": true, "searchable": false}, //#
                        {"width": "05%", "targets": 1, "type": "string", "visible": true},  //ref
                        {"width": "05%", "targets": 2, "type": "string", "visible": true},  //code

                        //{"width": "08%", "targets": 3, "type": "string", "visible": true},    //desi
                        {"width": "08%", "targets": 3, "type": "string", "visible": false},     //Marque
                        {"width": "08%", "targets": 4, "type": "string", "visible": false},     //caegorie

                        {"width": "02%", "targets": 5, "type": "string", "visible": true},      //HT
                        {"width": "02%", "targets": 6, "type": "num-fmt", "visible": true},     //TTC
                        {"width": "02%", "targets": 7, "type": "string", "visible": true},      //HT
                        {"width": "02%", "targets": 8, "type": "num-fmt", "visible": true},     //TTC

                        //{"width": "05%", "targets": 10, "type": "num-fmt", "visible": true},     //etat

                        {"width": "04%", "targets": 9, "type": "num-fmt", "visible": true, "searchable": false}
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


                //permet de d inclure les tt les pages
                $('#myForm').on('submit', function (e) {
                    var form = this;

                    // Encode a set of form elements from all pages as an array of names and values
                    var params = table.$('input,select,textarea').serializeArray();

                    // Iterate over all form elements
                    $.each(params, function () {
                        // If element doesn't exist in DOM
                        if (!$.contains(document, form[this.name])) {
                            // Create a hidden element
                            $(form).append(
                                    $('<input>').attr('type', 'hidden').attr('name', this.name).val(this.value)
                            );
                        }
                    });
                });

            });
        </script>
    @endif
    <script>
        $(function () {
            if (!Modernizr.inputtypes.date) {
                $('input[type=date]').datepicker({
                            dateFormat: 'yy-mm-dd'
                        }
                );
            }
        });
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.css') }}"/>
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

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection
