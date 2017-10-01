@extends('layouts.main_master')

@section('title') Detail de vente  @endsection

@section('styles')
    <link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="{{  asset('table2/datatables.min.js') }}"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function () {
                var title = $(this).text();
                if (title == "Article") {
                    $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                } else if (title == "Prix unitaire") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                } else if (title == "Quantité") {
                    $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                } else if (title == "Total") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                } else if (title == "") {
                    //$(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }

            });
            var table = $('#example').DataTable({
                //"scrollY": "50px",
                //"scrollX": true,
                "searching": true,
                "paging": true,
                //"autoWidth": true,
                "info": true,
                stateSave: false,
                "columnDefs": [
                    {"width": "02%", "targets": 0, "type": "num", "visible": true, "searchable": false},
                    {"width": "07%", "targets": 2, "type": "string", "visible": true},
                    {"width": "05%", "targets": 3, "type": "string", "visible": true},
                    {"width": "05%", "targets": 4, "type": "string", "visible": true},
                    {"width": "03%", "targets": 5, "type": "string", "visible": true}
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

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Detail de la vente </h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vend.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Gestion des Articles</li>
                    <li class="breadcrumb-item active">Liste des articles</li>
                </ol>


                {{-- **************Alerts**************  --}}
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        {{-- Debut Alerts --}}
                        @if (session('alert_success'))
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button> {!! session('alert_success') !!}
                            </div>
                        @endif
                        @if (session('alert_info'))
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button> {!! session('alert_info') !!}
                            </div>
                        @endif
                        @if (session('alert_warning'))
                            <div class="alert alert-warning alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button> {!! session('alert_warning') !!}
                            </div>
                        @endif
                        @if (session('alert_danger'))
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button> {!! session('alert_danger') !!}
                            </div>
                        @endif
                        {{-- Fin Alerts --}}
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                {{-- **************endAlerts**************  --}}

                <div class="row">
                    <div class="table-responsive">
                        <div class="col-lg-12">
                            <table class="table table-striped table-bordered table-hover" id="example">
                                <thead bgcolor="#DBDAD8">
                                <tr>
                                    <th>#</th>
                                    <th><i class="fa fa-fw fa-sort"></i> Article</th>
                                    <th><i class="fa fa-fw fa-sort"></i> Prix unitaire</th>
                                    <th><i class="fa fa-fw fa-sort"></i> Quantité</th>
                                    <th><i class="fa fa-fw fa-sort"></i> PU x Qts</th>
                                    <th>Autre</th>
                                </tr>
                                </thead>
                                <tfoot bgcolor="#DBDAD8">
                                <tr>
                                    <th></th>
                                    <th>Article</th>
                                    <th>Prix unitaire</th>
                                    <th>Quantité</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                                <tbody>

                                @foreach( $data as $item )
                                    <!-- probleme des remises et des promotions -->
                                    <tr>
                                        <td align="right" width=1%>{{ $loop->index+1 }}</td>
                                        <td>{{ getChamp('articles','id_article',$item->id_article, 'designation_c') }}</td>
                                        <td align="right">{{ number_format($item->prix,2) }} DH
                                        </td>
                                        <td align="right">{{ $item->quantite }}</td>
                                        <td align="right">{{ number_format(($item->prix * $item->quantite),2) }} DH</td>
                                        <td align="center">
                                            <a data-toggle="modal" data-target="#modal{{ $loop->index+1 }}"
                                               title="Detail article">
                                                <i class="glyphicon glyphicon-eye-open" {!! setPopOver("","Afficher plus de detail") !!}></i>
                                            </a>
                                        </td>
                                    </tr>

                                    {{-- Modal (pour afficher les details de chaque article) --}}
                                    <div class="modal fade" id="modal{{ $loop->index+1 }}" role="dialog">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        &times;
                                                    </button>
                                                    <h4 class="modal-title">{{ $item->designation_c }}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p><b>numero</b> {{ $item->num_article }}</p>
                                                    <p><b>code a barres</b> {{ $item->code_barre }}</p>
                                                    <p><b>Taille</b> {{ $item->taille }}</p>
                                                    <p><b>Couleur</b> {{ $item->couleur }}</p>
                                                    <p><b>sexe</b> {{ getSexeName($item->sexe) }}</p>
                                                    <p><b>Prix de vente</b></p>
                                                    <p>{{ number_format($item->prix_vente, 2) }} Dhs
                                                        HT, {{ number_format($item->prix_vente+$item->prix_vente*0.2, 2) }}
                                                        Dhs TTC </p>
                                                    <p>{{ $item->designation_l }}</p>
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
                                @endforeach
                                <tfoot>
                                <tr>
                                    <td colspan="4"><strong>Total</strong></td>
                                    <td align="right">{{ $total }} DH TTC</td>
                                    <td></td>
                                </tr>
                                </tfoot>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- row -->


                <!-- row -->
                <div class="row" align="center">
                    <a onclick="return alert('Printing ....')" type="button"
                       class="btn btn-outline btn-primary"><i class="fa fa-file-pdf-o" aria-hidden="true">
                            Imprimer </i></a>

                <!-- <a href="{{ Route('vend.addVente',[ 'p_id_mag' =>getChamp('transactions', 'id_transaction', $data->first()->id_transaction , 'id_magasin') ]) }}" type="button" class="btn btn-outline btn-default">  Ajouter une vente </a>

        <a href="{{ Route('vend.lister',[ 'p_table' => 'stocks','p_id_user'=>3 ]) }}" type="button" class="btn btn-outline btn-default">  Voir Stock </a>
  -->
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection

@section('menu_1')
    @include('Espace_Vend._nav_menu_1')
@endsection

@section('menu_2')
    @include('Espace_Vend._nav_menu_2')
@endsection
