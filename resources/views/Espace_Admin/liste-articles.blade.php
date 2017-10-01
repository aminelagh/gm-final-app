@extends('layouts.main_master')

@section('title') Liste des articles @endsection

@section('main_content')

    <h3 class="page-header">Liste des articles</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Liste des articles</li>
    </ol>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">

                <div class="breadcrumb">
                    Afficher/Masquer:
                    <a class="toggle-vis" data-column="0">reference</a> -
                    <a class="toggle-vis" data-column="1">Code</a> -
                    <a class="toggle-vis" data-column="2">Article</a> -
                    <a class="toggle-vis" data-column="3">Categorie</a> -
                    <a class="toggle-vis" data-column="4">Fournisseur</a> -
                    <a class="toggle-vis" data-column="5">Marque</a> -
                    <a class="toggle-vis" data-column="6">Couleur</a> -
                    <a class="toggle-vis" data-column="7">Sexe</a> -
                    <a class="toggle-vis" data-column="8">Prix de vente</a>
                </div>


                <table class="table table-striped table-bordered table-hover" id="myTable">
                    <thead>
                    <tr>

                        <th>Reference</th>
                        <th>Code</th>

                        <th>Designation</th>

                        <th>Categorie</th>
                        <th>Fournisseur</th>
                        <th>Marque</th>

                        <th>Couleur</th>
                        <th>Sexe</th>

                        <th>Prix d'achat (HT)</th>
                        <th>Prix de vente (TTC)</th>

                        <th>Etat</th>
                        <th>Details</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Reference</th>
                        <th>Code</th>
                        <th>Designation</th>
                        <th>Categorie</th>
                        <th>Fournisseur</th>
                        <th>Marque</th>
                        <th>Couleur</th>
                        <th>Sexe</th>
                        <th>Prix d'achat</th>
                        <th>Prix de vente</th>
                        <th></th>
                        <th></th>
                    </tfoot>

                    <tbody>
                    @foreach( $data as $item )
                        <tr>
                            <td>{{ $item->ref }} {{ $item->alias!=null ? ' - '.$item->alias : '' }}</td>
                            <td>{{ $item->code }}</td>
                            <td><a href="{{ route('admin.article',[ $item->id_article]) }}">{{$item->designation}}</a>
                            </td>
                            <td>{{ $item->id_categorie  }}</td>
                            <td>{{ $item->libelle_f }}</td>
                            <td>{{ $item->libelle_m }}</td>
                            <td>{{ $item->couleur }}</td>
                            <td>{{ $item->sexe }}</td>
                            <td align="right">{{ $item->prix_a }}</td>
                            <td align="right">{{ \App\Models\Article::HTtoTTC($item->prix_v)." ".$item->prix_v }}</td>
                            <td align="middle">
                                @if($item->valide==false)
                                    <div id="circle"
                                         style="background: darkred;" {!! setPopOver("","  Non validé") !!}></div>
                                @elseif($item->valide==true)
                                    <div id="circle"
                                         style="background: greenyellow;" {!! setPopOver("","Validé") !!}></div>
                                @endif
                            </td>
                            <td align="center">

                                <a data-toggle="modal" data-target="#modal{{ $loop->iteration }}"><i
                                            class="glyphicon glyphicon-info-sign"
                                            aria-hidden="false"></i></a>

                                {{-- Modal (pour afficher les details de chaque article) --}}
                                <div class="modal fade" id="modal{{ $loop->iteration }}" role="dialog">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">
                                                    &times;
                                                </button>
                                                <h4 class="modal-title">{{ $item->designation }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <tr>
                                                        <td>Reference</td>
                                                        <th>{{ $item->ref }} - {{ $item->alias }}</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Code</td>
                                                        <th>{{ $item->code }}</th>
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
                                                        <td colspan="2" align="center">Prix d'achat</td>
                                                    </tr>
                                                    <tr>
                                                        <th align="right">{{ number_format($item->prix_a,2) }}
                                                            Dhs HT
                                                        </th>
                                                        <th>{{ \App\Models\Article::HTtoTTC($item->prix_a) }}
                                                            Dhs TTC
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" align="center">Prix de vente</td>
                                                    </tr>
                                                    <tr>
                                                        <th align="right">{{ number_format($item->prix_v,2) }}
                                                            Dhs HT
                                                        </th>
                                                        <th>{{ \App\Models\Article::HTtoTTC($item->prix_v) }}
                                                            Dhs TTC
                                                        </th>
                                                    </tr>
                                                </table>
                                                @if( $item->image != null)
                                                    <img src="{{ asset($item->image) }}" width="150px">
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-lg-4">
                                                    <form action="{{ route('admin.deleteArticle',[$item->id_article]) }}"
                                                          method="post">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger btn-outline">
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="col-lg-4">
                                                    <a href="{{ route('admin.article',[$item->id_article]) }}"
                                                       class="btn btn-info btn-outline">
                                                        Modifier
                                                    </a>
                                                </div>
                                                <div class="col-lg-4">
                                                    <button type="button" class="btn btn-info btn-outline"
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

            </div>
        </div>
    </div>


@endsection

@section('scripts')
    @if(!$data->isEmpty())
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function () {
                // Setup - add a text input to each footer cell
                $('#myTable tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Reference" || title == "Code") {
                        $(this).html('<input type="text" size="6" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Categorie" || title == "Fournisseur" || title == "Marque") {
                        $(this).html('<input type="text" size="8" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Designation") {
                        $(this).html('<input type="text" size="15" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Couleur" || title == "Sexe") {
                        $(this).html('<input type="text" size="5" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Prix") {
                        $(this).html('<input type="text" size="4" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                });

                var table = $('#myTable').DataTable({
                    "lengthMenu": [[10, 20, 30, 50, -1], [10, 20, 30, 50, "Tout"]],
                    "searching": true,
                    "paging": true,
                    //"autoWidth": true,
                    "info": true,
                    stateSave: false,
                    "columnDefs": [
                        {"width": "10%", "targets": 0, "type": "num", "visible": true, "searchable": false},//#
                        {"width": "10%", "targets": 1, "type": "string", "visible": true},
                        {"width": "40%", "targets": 2, "type": "string", "visible": true},

                        //{"width": "08%", "targets": 3, "type": "string", "visible": true},

                        {"width": "08%", "targets": 3, "type": "string", "visible": false},
                        {"width": "08%", "targets": 4, "type": "string", "visible": false},
                        {"width": "02%", "targets": 5, "type": "string", "visible": false},

                        {"width": "06%", "targets": 6, "type": "num-fmt", "visible": false},
                        {"width": "06%", "targets": 7, "type": "string", "visible": false},

                        {"width": "04%", "targets": 8, "type": "num-fmt", "visible": true},
                        {"width": "04%", "targets": 9, "type": "num-fmt", "visible": true},
                        {"width": "04%", "targets": 10, "type": "num-fmt", "visible": true},
                        {"width": "04%", "targets": 11, "type": "num-fmt", "visible": true, "searchable": false}
                    ]
                });

                // table.on('order.dt search.dt', function () {
                //     table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                //         cell.innerHTML = i + 1;
                //     });
                // }).draw();


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
