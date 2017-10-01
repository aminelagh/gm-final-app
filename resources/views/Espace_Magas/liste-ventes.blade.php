@extends('layouts.main_master')

@section('title') Ventes du magasin @endsection

@section('main_content')
    <h3 class="page-header">Liste des ventes</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des transactions</li>
        <li class="breadcrumb-item active"><a href="{{ route('magas.ventes') }}">Liste des ventes</a></li>
    </ol>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Magasin</th>
                        <th>Date</th>
                        <th>Mode Paiement</th>
                        <th>Articles</th>
                        <th>Total</th>
                        <th>Details</th>
                    </tr>
                    </thead>
                    @if( !$data->isEmpty() )
                        <tfoot>
                        <tr>
                            <th>User</th>
                            <th>Magasin</th>
                            <th>Date</th>
                            <th>Mode Paiement</th>
                            <th>Articles</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    @endif

                    <tbody>

                    @if( $data->isEmpty() )
                        <tr>
                            <td colspan="7" align="center"><i>Aucune vente</i></td>
                        </tr>
                    @else
                        @foreach( $data as $item )
                            <tr>
                                <td>{{ \App\Models\User::getNomUser($item->id_user) }}
                                {{ \App\Models\User::getPrenomUser($item->id_user) }}
                              </td>
                                <th>{{ \App\Models\Magasin::getLibelle($item->id_magasin) }}</th>
                                <td >{{ getDateHelper(\App\Models\Vente::getDate($item->id_vente)) }}</td>
                                <td>{{ \App\Models\Vente::getMode($item->id_paiement) }}</td>
                                <td align="right">{{ \App\Models\Vente::getNombreArticles($item->id_vente) }}
                                    Article(s)
                                </td>
                                <td align="right">{{ \App\Models\Vente::getNombrePieces($item->id_vente) }} piece(s)
                                </td>
                                <td align="center">
                                    <a data-toggle="modal" data-target="#modal{{ $loop->iteration }}"><i
                                                class="glyphicon glyphicon-info-sign"
                                                aria-hidden="false"></i></a>

                                    <a href="{{ Route('magas.vente',['p_id' => $item->id_vente]) }}"
                                            {!! setPopOver("","Details") !!} ><i
                                                class="glyphicon glyphicon-shopping-cart"></i>
                                    </a>



                                    {{-- Modal (pour afficher les details de chaque transaction) --}}
                                    <div class="modal fade" id="modal{{ $loop->iteration }}" role="dialog"
                                         tabindex="-1" aria-labelledby="gridSystemModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                    <h3 class="modal-title" id="gridSystemModalLabel">
                                                        <b>{{ getDateHelper($item->date).' a '.getTimeHelper($item->date) }}</b>
                                                    </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">

                                                            @if( \App\Models\Vente::getVente_articles($item->id_vente)->isEmpty())
                                                                <h3><i>Aucun article</i></h3>
                                                            @else
                                                                <table class="table table-striped table-bordered table-hover">
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Article</th>
                                                                        <th>Taille</th>
                                                                        <th>Quantite</th>
                                                                    </tr>

                                                                    @foreach(\App\Models\Vente::getVente_articles($item->id_vente) as $vente_article)
                                                                        <tr>
                                                                            <td align="right">{{ $loop->iteration }}</td>
                                                                            <td align="center">{{ \App\Models\Article::getDesignation($vente_article->id_article) }}</td>
                                                                            <td align="right">{{ \App\Models\Taille_article::getTaille($vente_article->id_taille_article) }}</td>
                                                                            <td align="right">{{ $vente_article->quantite }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </table>
                                                            @endif

                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- fin Modal (pour afficher les details de chaque vente) --}}
                                </td>


                            </tr>
                        @endforeach
                    @endif
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
                    //"scrollY": "50px",
                    //"scrollX": true,
                    "searching": true,
                    "paging": true,
                    //"autoWidth": true,
                    "info": true,
                    stateSave: false,
                    "columnDefs": [
                        {"width": "20%", "targets": 0},
                        {"width": "30%", "targets": 1},
                        //{"width": "05%", "targets": 2},
                        {"width": "05%", "targets": 3},
                        {"width": "05%", "targets": 4},
                        {"width": "05%", "targets": 5}
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
                    if (title == "Date") {
                        $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Articles" || title == "Total") {
                        $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="4" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                });

                $('a.toggle-vis').on('click', function (e) {
                    e.preventDefault();
                    var column = table.column($(this).attr('data-column'));
                    column.visible(!column.visible());
                });

                // Apply the search
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

@section('menu_1') @include('Espace_Magas._nav_menu_1') @endsection
@section('menu_2') @include('Espace_Magas._nav_menu_2') @endsection
