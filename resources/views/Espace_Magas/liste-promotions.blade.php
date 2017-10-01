@extends('layouts.main_master')

@section('title') Promotions @endsection

@section('main_content')
    <h3 class="page-header">Promotions</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des promotions</li>
        <li class="breadcrumb-item active"><a href="{{ route('magas.promotions') }}">Liste des promotions</a></li>
    </ol>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="example" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Article</th>
                        <th>Taux</th>
                        <th>Periode</th>
                        <th>Etat</th>
                        <th>Details</th>
                    </tr>
                    </thead>
                    @if( !$data->isEmpty() )
                        <tfoot>
                        <tr>
                            <th>Article</th>
                            <th>Taux</th>
                            <th>Periode</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    @endif

                    <tbody>

                    @if( $data->isEmpty() )
                        <tr>
                            <td colspan="5" align="center"><i>Aucune promotion</i></td>
                        </tr>
                    @else
                        @foreach( $data as $item )
                            <tr>
                                <td>
                                    <a href="{{ route('magas.article',[ $item->id_article]) }}"> {{ $item->designation }}</a>
                                </td>
                                <td align="right">{{ $item->taux }} %</td>
                                <td align="middle">{{ getDateHelper($item->date_debut) }}
                                    -- {{ getDateHelper($item->date_fin) }} </td>
                                <td align="middle">
                                    @if(\App\Models\Promotion::hasPromotion($item->id_article) == false)
                                        <div id="circle"
                                             style="background: darkred;" {!! setPopOver(""," Indisponible") !!}></div>
                                    @elseif(\App\Models\Promotion::hasPromotion($item->id_article) == true)
                                        <div id="circle"
                                             style="background: greenyellow;" {!! setPopOver("","Disponible") !!}></div>
                                    @endif
                                </td>
                                <td align="middle">
                                    <a data-toggle="modal"
                                       data-target="#modal{{ $loop->iteration }}" {!! setPopOver("","Details/Modifier/Supprimer") !!}><i
                                                class="glyphicon glyphicon-info-sign"></i></a>
                                    </a>


                                    {{-- Modal (pour afficher les details de chaque article) --}}
                                    <div class="modal fade" id="modal{{ $loop->iteration }}" role="dialog"
                                         tabindex="-1" aria-labelledby="gridSystemModalLabel">
                                        <div class="modal-dialog" role="document">
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
                                                            <td>Prix d'achat</td>
                                                            <th>{{ \App\Models\Article::getPrixAchatHT($item->id_article) }} Dhs HT</th>
                                                            <th>{{ \App\Models\Article::getPrixAchatTTC($item->id_article) }} Dhs TTC</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Prix de vente</td>
                                                            <th>{{ \App\Models\Article::getPrixHT($item->id_article) }} Dhs HT</th>
                                                            <th>{{ \App\Models\Article::getPrixTTC($item->id_article) }} Dhs TTC</th>
                                                        </tr>
                                                    </table>
                                                    @if($item->image!=null)
                                                        <img src="{{ $item->image }}"
                                                             width="200" hight="200">
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-lg-4">

                                                    </div>

                                                    <div class="col-lg-4">
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
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <!-- row -->


@endsection

@section('scripts')
    @if( !$data->isEmpty() )
        <script>
            $(document).ready(function () {

                // DataTable
                var table = $('#example').DataTable({
                    "lengthMenu": [[10, 20, 30, 50, -1], [10, 20, 30, 50, "Tout"]],
                    "searching": true,
                    "paging": true,
                    "info": true,
                    stateSave: false,
                    "columnDefs": [
                        //{"width": "40%", "targets": 0, "type": "string", "visible": true},
                        {"width": "08%", "targets": 1, "type": "string", "visible": true},
                        //{"width": "40%", "targets": 2, "type": "string", "visible": true},
                        {"width": "05%", "targets": 3, "type": "string", "visible": true},
                        {"width": "05%", "targets": 4, "type": "string", "visible": true}
                        //{"width": "10%", "targets": 5, "type": "string", "visible": true},
                        //{"width": "30%", "targets": 6, "type": "string", "visible": true}
                    ],
                    "order": [[1, 'asc']],
                    "select": {items: 'column'}
                });

                // table.on('order.dt search.dt', function () {
                //     table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                //         cell.innerHTML = i + 1;
                //     });
                // }).draw();

                // Setup - add a text input to each footer cell
                $('#example tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Magasin") {
                        $(this).html('<input type="text" size="8" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Article") {
                        $(this).html('<input type="text" size="10" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Taux") {
                        $(this).html('<input type="text" size="1" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Periode") {
                        $(this).html('<input type="text" size="20" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
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


            })
            ;
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

        #example {
            width: 100%;
            border: 0px solid #D9D5BE;
            border-collapse: collapse;
            margin: 0px;
            background: white;
            font-size: 1em;
        }

        #example td {
            padding: 2px;
        }
    </style>
@endsection

@section('menu_1') @include('Espace_Magas._nav_menu_1') @endsection
@section('menu_2') @include('Espace_Magas._nav_menu_2') @endsection
