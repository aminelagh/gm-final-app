@extends('layouts.main_master')

@section('title') Articles @endsection

@section('main_content')

    <h3 class="page-header">Liste des Articles</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des Articles</li>
        <li class="breadcrumb-item active"><a href="{{ route('magas.articles') }}">Liste des articles</a></li>
    </ol>

    <!-- Table -->
    <div class="table-responsive">
        <div class="col-lg-12">
            @if( !$data->isEmpty() )
                <div class="breadcrumb">
                    Afficher/Masquer:
                    <a class="toggle-vis" data-column="0">Reference</a> -
                    <a class="toggle-vis" data-column="1">Code</a> -
                    <a class="toggle-vis" data-column="2">Designation</a> -
                    <a class="toggle-vis" data-column="3">Categorie</a> -
                    <a class="toggle-vis" data-column="4">Fournisseur</a> -
                    <a class="toggle-vis" data-column="5">Marque</a> -
                    <a class="toggle-vis" data-column="6">Couleur</a> -
                    <a class="toggle-vis" data-column="7">Sexe</a> -
                    <a class="toggle-vis" data-column="8">Prix d'achat</a> -
                    <a class="toggle-vis" data-column="9">Prix de vente</a>
                </div>
            @endif

            <table id="myTable" class="table table-striped table-bordered table-hover">
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
                    <th title="Prix d'achat HT">Prix achat (HT)</th>
                    <th title="Prix de vente TTC">Prix vente (TTC)</th>
                    <th>Details</th>
                </tr>
                </thead>
                @if( !$data->isEmpty() )
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
                        <th>Prix</th>
                        <th>Prix</th>
                        <th></th>
                    </tr>
                    </tfoot>
                @endif
                <tbody>
                @if( $data->isEmpty() )
                    <tr>
                        <td align="center" colspan="11">Aucun Article</td>
                    </tr>
                @else
                    @foreach( $data as $item )
                        @if($item->valide == true)
                            <tr ondblclick="window.open('{{ Route('magas.article',['p_id'=>$item->id_article]) }}');">
                        @else
                            <tr class="warning"
                                ondblclick="window.open('{{ Route('magas.article',['p_id'=>$item->id_article]) }}');" {!! setPopOver("","Article non validé par l'administrateur") !!}>
                                @endif

                                <td align="right">
                                    {{ \App\Models\Article::getRef($item->id_article) }}
                                    {{ \App\Models\Article::getAlias($item->id_article)!=null ? ' - '.\App\Models\Article::getAlias($item->id_article):' ' }}
                                </td>
                                <td align="right">{{ $item->code }}</td>
                                <td>
                                    @if( App\Models\Article::getImage($item->id_article) != null) <img
                                            src="{{ asset(App\Models\Article::getImage($item->id_article)) }}"
                                            width="40px">@endif
                                    {{ $item->designation }}
                                </td>
                                <td>{{ $item->libelle_c }}</td>
                                <td>{{ $item->libelle_f }}</td>
                                <td>{{ $item->libelle_m }}</td>
                                <td>{{ $item->couleur }}</td>
                                <td>{{ $item->sexe }}</td>
                                <td align="right">{{ number_format($item->prix_a,2) }}</td>
                                <td align="right">{{ number_format($item->prix_v*1.2,2) }}</td>
                                <td align="center">
                                    <a data-toggle="modal" data-target="#modal{{ $loop->iteration }}">
                                        <i class="glyphicon glyphicon-info-sign" aria-hidden="false"></i>
                                    </a>


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
                                                            <td>Marque</td>
                                                            <th>{{ $item->libelle_m }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Catégorie</td>
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
                                                            <td colspan="2" align="center">Prix d'achat</td>
                                                        </tr>
                                                        <tr>
                                                            <th align="right">{{ number_format($item->prix_a,2) }} Dhs HT</th>
                                                            <th>{{ number_format($item->prix_a*1.2,2) }} Dhs TTC</th>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" align="center">Prix de vente</td>
                                                        </tr>
                                                        <tr>
                                                            <th align="right">{{ number_format($item->prix_v,2) }} Dhs HT</th>
                                                            <th>{{ number_format($item->prix_v*1.2,2) }} Dhs TTC</th>
                                                        </tr>
                                                    </table>
                                                    @if( $item->image != null) <img src="{{ asset($item->image) }}" width="150px">@endif
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-lg-4">
                                                        <form action="{{ route('magas.deleteArticle',[$item->id_article]) }}" method="post">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit" class="btn btn-danger btn-outline">Supprimer</button>
                                                        </form>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <a href="{{ route('magas.article',[$item->id_article]) }}" class="btn btn-info btn-outline">Modifier</a>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <button type="button" class="btn btn-info btn-outline" data-dismiss="modal">Fermer</button>
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

    <!-- row -->
    <div class="row" align="center">
        <a href="{{ Route('magas.addArticle') }}" type="button"
           class="btn btn-outline btn-default" {!! setPopOver("","Ajouter un nouvel article") !!}> <i
                    class="glyphicon glyphicon-plus "></i> Ajouter un Article</a>

    </div>
    <hr/>

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
                    "info": false,
                    stateSave: false,
                    "columnDefs": [
                        {"width": "04%", "targets": 0, "type": "num", "visible": true, "searchable": false},//#
                        {"width": "05%", "targets": 1, "type": "string", "visible": true},
                        {"width": "05%", "targets": 2, "type": "string", "visible": true},

                        //{"width": "08%", "targets": 3, "type": "string", "visible": true},

                        {"width": "08%", "targets": 3, "type": "string", "visible": false},
                        {"width": "08%", "targets": 4, "type": "string", "visible": false},
                        {"width": "02%", "targets": 5, "type": "string", "visible": false},

                        {"width": "06%", "targets": 6, "type": "num-fmt", "visible": false},
                        {"width": "06%", "targets": 7, "type": "string", "visible": false},

                        {"width": "04%", "targets": 8, "type": "num-fmt", "visible": true},
                        {"width": "04%", "targets": 9, "type": "num-fmt", "visible": true},
                        {"width": "04%", "targets": 10, "type": "num-fmt", "visible": true, "searchable": false}
                    ]
                });

                // table.on('order.dt search.dt', function () {
                //     table.column(-20, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
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

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection
