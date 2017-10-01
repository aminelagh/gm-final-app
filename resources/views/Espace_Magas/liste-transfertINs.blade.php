@extends('layouts.main_master')

@section('title') Transfert IN de stock @endsection

@section('main_content')
    <h3 class="page-header">Liste des Transferts de stock vers le magasin Principal</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des transactions</li>
        <li class="breadcrumb-item active">
            <a href="{{ route('magas.transfertINs') }}">Liste des transferts de stock</a>
        </li>
    </ol>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Date</th>
                        <th>Magasin source</th>
                        <th>Articles</th>
                        <th>Total</th>
                        <th>Details</th>
                    </tr>
                    </thead>
                    @if( !$data->isEmpty() )
                        <tfoot>
                        <tr>
                            <th>User</th>
                            <th>Date</th>
                            <th>Magasin source</th>
                            <th>Articles</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    @endif

                    <tbody>

                    @if( $data->isEmpty() )
                        <tr>
                            <td colspan="5" align="center"><i>Aucun transfert de stock</i></td>
                        </tr>
                    @else
                        @foreach( $data as $item )
                            <tr>
                              <td>{{ \App\Models\User::getNomUser($item->id_user) }}
                              {{ \App\Models\User::getPrenomUser($item->id_user) }}
                            </td>
                                <td onclick="window.location.href='{{ route('magas.transfertOUT',['p_id'=>$item->id_transaction]) }}'">{{ getDateHelper($item->date).' a '.getTimeHelper($item->date) }}</td>

                                <td>{{ \App\Models\Magasin::getLibelle($item->id_magasin) }}
                                    ({{ \App\Models\Magasin::getVille($item->id_magasin) }})
                                </td>
                                <td align="right">{{ \App\Models\Transaction::getNombreArticles($item->id_transaction) }}
                                    Article(s)
                                </td>
                                <td align="right">
                                    {{ \App\Models\Transaction::getNombrePieces($item->id_transaction) }} pièce(s)
                                </td>
                                <td align="center">
                                    <a data-toggle="modal" data-target="#modal{{ $loop->iteration }}"><i
                                                class="glyphicon glyphicon-info-sign"
                                                aria-hidden="false"></i></a>

                                    <a href="{{ Route('magas.transfertIN',['p_id' => $item->id_transaction ]) }}"
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
                                                        <b>{{ getDateHelper($item->date).' a '.getTimeHelper($item->date) }}</b>
                                                    </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">

                                                            @if( \App\Models\Transaction::getTrans_articles($item->id_transaction)->isEmpty())
                                                                <h3><i>Aucun article</i></h3>
                                                            @else
                                                                <table class="table table-striped table-bordered table-hover">
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Article</th>
                                                                        <th>Taille</th>
                                                                        <th>Quantite</th>
                                                                    </tr>

                                                                    @foreach(\App\Models\Transaction::getTrans_articles($item->id_transaction) as $trans_article)
                                                                        <tr>
                                                                            <td align="right">{{ $loop->iteration }}</td>
                                                                            <td align="center">{{ \App\Models\Article::getDesignation($trans_article->id_article) }}</td>
                                                                            <td align="right">{{ \App\Models\Taille_article::getTaille($trans_article->id_taille_article) }}</td>
                                                                            <td align="right">{{ $trans_article->quantite }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </table>
                                                            @endif

                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Fermer
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
                        {"width": "20%", "targets": 0},
                        //{"width": "30%", "targets": 1},
                        {"width": "20%", "targets": 1},
                        {"width": "20%", "targets": 2},
                        {"width": "20%", "targets": 3},
                        {"width": "20%", "targets": 4},
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
