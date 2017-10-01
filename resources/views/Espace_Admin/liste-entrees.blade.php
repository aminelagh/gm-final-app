@extends('layouts.main_master')

@section('title') Entrees de stock @endsection

@section('main_content')
    <h3 class="page-header">Entrées de stock</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des transactions</li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.entrees') }}">Liste des entrees de stock</a></li>
    </ol>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Utilisateur</th>
                        <th>Articles</th>
                        <th>Total</th>
                        <th>Details</th>
                    </tr>
                    </thead>
                    @if( !$data->isEmpty() )
                        <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>Utilisateur</th>
                            <th>Articles</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    @endif

                    <tbody>

                    @if( $data->isEmpty() )
                        <tr>
                            <td colspan="4" align="center"><i>Aucune entree de stock</i></td>
                        </tr>
                    @else
                        @foreach( $data as $item )
                            <tr>
                                <td>{{ getDateHelper($item->date).' a '.getTimeHelper($item->date) }}</td>
                                <td><a href="{{ route('admin.user',[$item->id_user]) }}">{{ $item->nom }} {{ $item->prenom }}</a></td>
                                <td align="right">{{ \App\Models\Transaction::getNombreArticles($item->id_transaction) }}
                                    Articles
                                </td>
                                <td align="right">{{ \App\Models\Transaction::getNombrePieces($item->id_transaction) }}
                                    pieces
                                </td>
                                <td align="center">
                                    <a data-toggle="modal" data-target="#modal{{ $loop->iteration }}"><i
                                                class="glyphicon glyphicon-info-sign"
                                                aria-hidden="false"></i></a>

                                    <a href="{{ Route('admin.entree',['p_id' => $item->id_transaction ]) }}"
                                            {!! setPopOver("","Details") !!} ><i
                                                class="glyphicon glyphicon-eye-open"></i>
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
                                                        <b>{{ getShortDateHelper($item->date).' a '.getTimeHelper($item->date) }}</b>
                                                    </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">

                                                            @if( \App\Models\Transaction::getTrans_articles($item->id_transaction)->isEmpty())
                                                                <h3><i>Aucun article</i></h3>
                                                            @else
                                                                <table id="myTable_{{ $loop->iteration }}"
                                                                       class="table table-striped table-bordered table-hover">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Article</th>
                                                                        <th>Taille</th>
                                                                        <th>Quantite</th>
                                                                    </tr>
                                                                    </thead>

                                                                    @foreach(\App\Models\Transaction::getTrans_articles($item->id_transaction) as $trans_article)
                                                                        <tr>
                                                                            <td align="center">{{ \App\Models\Article::getDesignation($trans_article->id_article) }}</td>
                                                                            <td align="right">{{ \App\Models\Taille_article::getTaille($trans_article->id_taille_article) }}</td>
                                                                            <td align="right">{{ $trans_article->quantite }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </table>

                                                                <script>
                                                                    $(document).ready(function () {
                                                                        var table = $('#myTable_{{ $loop->iteration }}').DataTable({
                                                                            //"scrollY": "50px",
                                                                            //"scrollX": true,
                                                                            "searching": true,
                                                                            "paging": true,
                                                                            //"autoWidth": true,
                                                                            "info": true,
                                                                            stateSave: false,
                                                                            "columnDefs": [
                                                                                //{"width": "5%", "targets": 0},
                                                                                {"width": "10%", "targets": 1},
                                                                                {"width": "10%", "targets": 2}
                                                                            ]
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
                                    {{-- fin Modal (pour afficher les details de chaque transaction) --}}
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
                        //{"width": "5%", "targets": 0},
                        {"width": "30%", "targets": 1},
                        {"width": "05%", "targets": 2},
                        {"width": "05%", "targets": 3},
                        {"width": "05%", "targets": 4},
                    ]
                });

                // Setup - add a text input to each footer cell
                $('#myTable tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Date") {
                        $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Articles" || title == "Total") {
                        $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Utilisateur") {
                        $(this).html('<input type="text" size="10" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
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

        #myTable2 {
            width: 100%;
            border: 0px solid #D9D5BE;
            border-collapse: collapse;
            margin: 0px;
            background: white;
            font-size: 1em;
        }

        #myTable2 td {
            padding: 5px;
        }

    </style>
@endsection

@section('menu_1') @include('Espace_Admin._nav_menu_1') @endsection
@section('menu_2') @include('Espace_Admin._nav_menu_2') @endsection
