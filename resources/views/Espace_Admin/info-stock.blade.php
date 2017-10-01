@extends('layouts.main_master')

@section('title')  {{ $article->designation.': ('.\App\Models\Stock::getNombreArticles($stock->id_stock).')' }} @endsection

@section('main_content')

    <h3 class="page-header">Stock du magasin principal:
        <strong>{{ $magasin->libelle }}</strong></h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des magasins</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.magasins') }}">Liste des magasins</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.magasin',['id_magasin'=>$magasin->id_magasin]) }}">{{ $magasin->libelle  }}</a>
        </li>
        <li class="breadcrumb-item">Stock</li>
        <li class="breadcrumb-item active">{{ $article->designation  }}</li>
    </ol>

    <div class="panel panel-info">
        <div class="panel-heading">
            {{ $article->designation }}
        </div>

        <table class="table table-striped table-bordered table-hover">
            <tr>
                <td align="right">Marque</td>
                <th>{{ \App\Models\Article::getMarque($article->id_article) }}</th>
                <td align="right">Categorie</td>
                <th>{{ \App\Models\Article::getCategorie($article->id_article) }}</th>
                <td align="right">Fournisseur</td>
                <th>{{ \App\Models\Article::getFournisseur($article->id_article) }}</th>
            </tr>
            <tr>
                <td align="right">Code</td>
                <th>{{ \App\Models\Article::getCode($article->id_article) }}</th>
                <td align="right">Reference</td>
                <th>{{ \App\Models\Article::getRef($article->id_article) }}
                    {{ \App\Models\Article::getAlias($article->id_article)!=null ? ' - '.\App\Models\Article::getAlias($article->id_article) : '' }}
                </th>
                <td align="center">Couleur: <b>{{ \App\Models\Article::getCouleur($article->id_article) }}</b></td>
                <td align="center">Sexe: <b>{{ \App\Models\Article::getSexe($article->id_article) }}</b></td>
            </tr>
            <tr>


            </tr>
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <th align="right">Prix de vente</th>
                <th align="right">{{ \App\Models\Article::getPrixHT($article->id_article) }} Dhs HT</th>
                <th align="left">{{ \App\Models\Article::getPrixTTC($article->id_article) }} Dhs TTC</th>

                <th align="right">Prix de gros</th>
                <th align="right">{{ \App\Models\Article::getPrixGrosHT($article->id_article) }} Dhs HT</th>
                <th align="left">{{ \App\Models\Article::getPrixGrosTTC($article->id_article) }} Dhs TTC</th>
            </tr>
            <tr>
                <th align="right">Prix d'achat</th>
                <th align="right">{{ \App\Models\Article::getPrixAchatHT($article->id_article) }} Dhs HT</th>
                <th align="left">{{ \App\Models\Article::getPrixAchatTTC($article->id_article) }} Dhs TTC</th>
            </tr>
        </table>

        <div class="panel-footer">
        </div>
    </div>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Taille</th>
                        <th>Quantite</th>

                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th>Taille</th>
                        <th>Quantite</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach( $data as $item )
                        <tr>
                            <td></td>
                            <td>{{ \App\Models\Taille_article::getTaille($item->id_taille_article) }}</td>
                            <td>{{ $item->quantite }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    @if( !$data->isEmpty() )
        <script>
            $(document).ready(function () {
                var table = $('#myTable').DataTable({
                    //"searching": true,
                    "paging": false,
                    "columnDefs": [
                        {"searchable": false, "orderable": false, "targets": 0},
                        //{"width": "05%", "targets": 1, "type": "string", "visible": false},
                        // {"width": "07%", "targets": 2, "type": "string", "visible": false},
                    ],
                    "order": [[1, 'asc']]
                    //"info": true,
                });

                table.on('order.dt search.dt', function () {
                    table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }).draw();

                // Setup - add a text input to each footer cell
                $('#myTable tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "numero" || title == "code") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Designation") {
                        $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Couleur" || title == "Sexe") {
                        $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
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

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection