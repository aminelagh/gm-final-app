@extends('layouts.main_master')

@section('title') Nouveaux articles @endsection

@section('main_content')
    <h3 class="page-header">Nouveaux articles</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des articles</li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.articles_nv') }}">Nouveaux articles</a></li>
    </ol>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">

                <div class="breadcrumb">
                    Afficher/Masquer:
                    <a class="toggle-vis" data-column="1">reference</a> -
                    <a class="toggle-vis" data-column="2">Code</a> -
                    <a class="toggle-vis" data-column="3">Desigantion</a> -
                    <a class="toggle-vis" data-column="4">Categorie</a> -
                    <a class="toggle-vis" data-column="5">Fournisseur</a> -
                    <a class="toggle-vis" data-column="6">Marque</a> -
                    <a class="toggle-vis" data-column="7">Couleur</a> -
                    <a class="toggle-vis" data-column="8">Sexe</a> -
                    <a class="toggle-vis" data-column="9">Prix de vente</a>
                </div>

                {{-- *************** formulaire ***************** --}}
                <form role="form" method="post" action="{{ Route('admin.submitArticlesValide') }}">
                    {{ csrf_field() }}

                    <table class="table table-striped table-bordered table-hover" id="myTable">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Reference</th>
                            <th>Code</th>
                            <th>Designation</th>
                            <th>Categorie</th>
                            <th>Fournisseur</th>
                            <th>Marque</th>
                            <th>Couleur</th>
                            <th>Sexe</th>
                            <th title="Prix d'achat HT">Prix achat</th>
                            <th title="Prix de vente TTC">Prix vente</th>
                            <th>Valide <br> <input type="checkbox" onclick="toggle(this);"/></th>
                            <th>Autres</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
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
                            <th></th>
                        </tfoot>

                        <tbody>
                        @foreach( $data as $item )
                            <tr ondblclick="window.open('{{ Route('admin.article',[$item->id_article]) }}');">
                                <input type="hidden" name="id_article[{{ $loop->index+1 }}]"
                                       value="{{ $item->id_article }}">

                                <td align="right"></td>
                                <td>{{ $item->ref }} {{ $item->alias!=null ? ' - '.$item->alias : '' }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->designation }}</td>
                                <td>{{ \App\Models\Article::getCategorie($item->id_article) }}</td>
                                <td>{{ \App\Models\Article::getFournisseur($item->id_article)  }}</td>
                                <td>{{ \App\Models\Article::getMarque($item->id_article)  }}</td>
                                <td>{{ $item->couleur }}</td>
                                <td>{{ $item->sexe }}</td>
                                <td align="right">{{ $item->prix_a }}</td>
                                <td align="right">{{ \App\Models\Article::getPrixTTC($item->id_article) }}</td>
                                <td align="center">
                                    <input type="checkbox" id="valide" name="valide[{{ $loop->index+1 }}]"
                                           value="{{ $loop->index+1 }}"/>
                                </td>
                                <td align="center">
                                    <a data-toggle="modal" data-target="#modal{{ $loop->iteration }}">
                                        <i class="glyphicon glyphicon-info-sign" aria-hidden="false"></i>
                                    </a>

                                    <a href="{{ Route('admin.article',['p_id'=> $item->id_article ]) }}"
                                            {!! setPopOver("","Details") !!}>
                                        <i class="glyphicon glyphicon-eye-open"></i>
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
                                                            <th align="right">{{ \App\Models\Article::getPrixAchatHT($item->id_article) }}
                                                                Dhs HT
                                                            </th>
                                                            <th>{{ \App\Models\Article::getPrixAchatTTC($item->id_article) }}
                                                                Dhs TTC
                                                            </th>
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
                                                    </table>
                                                    @if( $item->image != null) <img
                                                            src="{{ asset($item->image) }}"
                                                            width="150px">@endif
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
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="row" align="center">
                        <input type="submit" value="valider"
                               class="btn btn-primary" {!! setPopOver("","Cliquez ici pour marquer les articles cochés comme étant valide") !!}>

                    </div>
                </form>

            </div>
        </div>
    </div>
    <br/>
@endsection

@section('scripts')
    @if(!$data->isEmpty())
        <script type="text/javascript" charset="utf-8">

            function toggle(source) {
                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i] != source)
                        checkboxes[i].checked = source.checked;
                }
            }

            var table = $('#myTable').DataTable({
                //"scrollY": "50px",
                //"scrollX": true,
                "searching": true,
                "paging": true,
                //"autoWidth": true,
                "info": true,
                stateSave: false,
                "columnDefs": [
                    {"width": "04%", "targets": 0, "type": "num", "visible": true, "searchable": false},//#
                    {"width": "05%", "targets": 1, "type": "string", "visible": true},
                    {"width": "2%", "targets": 2, "type": "string", "visible": true},

                    //{"width": "08%", "targets": 3, "type": "string", "visible": true},

                    {"width": "08%", "targets": 4, "type": "string", "visible": false},
                    {"width": "08%", "targets": 5, "type": "string", "visible": false},
                    {"width": "08%", "targets": 6, "type": "string", "visible": false},

                    {"width": "02%", "targets": 7, "type": "string", "visible": false},
                    {"width": "06%", "targets": 8, "type": "num-fmt", "visible": false},

                    {"width": "04%", "targets": 9, "type": "num-fmt", "visible": true},
                    {"width": "04%", "targets": 10, "type": "num-fmt", "visible": true},

                    {"width": "08%", "targets": 11, "type": "num-fmt", "visible": true, "searchable": false},
                    {"width": "08%", "targets": 12, "type": "num-fmt", "visible": true, "searchable": false},
                ]
            });

            table.on('order.dt search.dt', function () {
                table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            $(document).ready(function () {
                // Setup - add a text input to each footer cell
                $('#myTable tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Reference" || title == "Code") {
                        $(this).html('<input type="text" size="8" class="form-control input-md" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Categorie" || title == "Fournisseur" || title == "Marque") {
                        $(this).html('<input type="text" size="8" class="form-control input-md" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Designation") {
                        $(this).html('<input type="text" size="15" class="form-control input-md" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Couleur" || title == "Sexe") {
                        $(this).html('<input type="text" size="5" class="form-control input-md" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Prix") {
                        $(this).html('<input type="text" size="4" class="form-control input-md" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
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
