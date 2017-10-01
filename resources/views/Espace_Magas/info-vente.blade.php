@extends('layouts.main_master')

@section('title') Entree de stock:  @endsection

@section('main_content')

    <h3 class="page-header">Entree de stock</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des transactions</li>
        <li class="breadcrumb-item"><a href="{{ route('magas.ventes') }}">Liste des ventes </a></li>

    </ol>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

            <div class="panel panel-default">
                <div class="panel-heading" align="center">
                    <h4><b>Detail de la vente</b></h4>
                </div>
                <div class="panel-body">
                    @if( $data->isEmpty())
                        <center><h3><i>Aucun article</i></h3></center>
                    @else
                        <table class="table table-striped table-bordered table-hover">
                            <tr>
                                <th>#</th>
                                <th>Article</th>
                                <th>Taille</th>
                                <th>Quantite</th>
                            </tr>

                            @foreach($data as $vente_article)
                                <tr>
                                    <td align="right">{{ $loop->iteration }}</td>
                                    <td align="center">
                                        <a href="{{ route('magas.article',['p_id'=>$vente_article->id_article]) }}">{{ \App\Models\Article::getDesignation($vente_article->id_article) }}</a>
                                    </td>
                                    <td align="right">{{ \App\Models\Taille_article::getTaille($vente_article->id_taille_article) }}</td>
                                    <td align="right">{{ $vente_article->quantite }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
                <div class="panel-footer" align="center"></div>
            </div>
        </div>
        <div class="col-lg-1"></div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#tableArticles tfoot th').each(function () {
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

            var table = $('#tableArticles').DataTable({
                //"scrollY": "50px",
                //"scrollX": true,
                "searching": true,
                "paging": true,
                //"autoWidth": true,
                "info": true,
                stateSave: false,
                "columnDefs": [
                    {"width": "02%", "targets": 0, "type": "num", "visible": true, "searchable": false},//#
                    {"width": "05%", "targets": 1, "type": "string", "visible": false},
                    {"width": "07%", "targets": 2, "type": "string", "visible": false},
                    {"width": "03%", "targets": 4, "type": "string", "visible": false},
                    {"width": "06%", "targets": 5, "type": "string", "visible": false},
                    {"width": "05%", "targets": 6, "type": "num-fmt", "visible": true},
                    {"width": "05%", "targets": 7, "type": "num-fmt", "visible": true},
                    {"width": "10%", "targets": 8, "type": "string", "visible": true, "searchable": false}
                ]
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
@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection
