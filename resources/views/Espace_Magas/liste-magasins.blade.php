@extends('layouts.main_master')

@section('title') Magasins @endsection

@section('main_content')
    <h3 class="page-header">Magasins </h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des magasins</li>
        <li class="breadcrumb-item active"><a href="{{ route('magas.magasins') }}">Liste des magasins</a></li>
    </ol>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="example" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Magasin</th>
                        <th>Ville</th>
                        <th>Details</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Magasin</th>
                        <th>Ville</th>
                        <th></th>
                    </tr>
                    </tfoot>

                    <tbody>

                    @if( $data->isEmpty() )
                        <tr>
                            <td align="center" colspan="4"><i>Aucun magasin</i></td>
                        </tr>
                    @else
                        @foreach( $data as $item )
                            <tr ondblclick="window.open('{{ Route('magas.magasin',['p_id'=>$item->id_magasin]) }}');">

                                <td><a href="{{ Route('magas.stocks',['id_magasin'=> $item->id_magasin ]) }}"> {{$item->libelle}}</a></td>
                                <td>{{ $item->ville }}</td>
                                <td align="center">

                                    <a data-toggle="modal" data-target="#modal{{ $loop->iteration }}">
                                        <i class="glyphicon glyphicon-info-sign" aria-hidden="false"></i>
                                    </a>

                                    <a href="{{ Route('magas.magasin',['p_id' => $item->id_magasin ]) }}"{!! setPopOver("","Afficher plus de detail") !!} >
                                        <i class="glyphicon glyphicon-eye-open"></i></a>


                                    {{-- Modal (pour afficher les details de chaque article) --}}
                                    <div class="modal fade" id="modal{{ $loop->iteration }}" role="dialog">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        &times;
                                                    </button>
                                                    <h4 class="modal-title">{{ $item->libelle }}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        <tr>
                                                            <td>Ville</td>
                                                            <th>{{ $item->ville }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Adresse</td>
                                                            <th>{{ $item->adresse }}</th>
                                                        </tr>
                                                    </table>
                                                    <table class="table table-striped table-bordered table-hover">
                                                        <tr>
                                                            <td>Agent</td>
                                                            <th>{{ $item->agent }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Telephone</td>
                                                            <th>{{ $item->telephone }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Email</td>
                                                            <th>{{ $item->email }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Date de création</td>
                                                            <th>{{ getDateHelper($item->created_at) }} a {{ getTimeHelper($item->created_at) }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Date de denière modification</td>
                                                            <th>{{ getDateHelper($item->updated_at) }} a {{ getTimeHelper($item->updated_at) }}</th>
                                                        </tr>


                                                    </table>
                                                    @if( $item->image != null) <img
                                                            src="{{ asset($item->image) }}"
                                                            width="150px">@endif

                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-lg-4">
                                                        <a href="{{ route('magas.magasin',[$item->id_magasin]) }}"
                                                           class="btn btn-info btn-outline">Modifier</a>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <button type="button" class="btn btn-info btn-outline" data-dismiss="modal">Fermer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- fin Modal (pour afficher les details de chaque categorie) --}}

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
    <div class="row" align="center">
        <a href="{{ Route('magas.addMagasin') }}" type="button"
           class="btn btn-outline btn-default" {!! setPopOver("","Ajouter un nouveau magasin") !!}>
            <i class="glyphicon glyphicon-plus "></i> Ajouter un magasin</a>
    </div>


@endsection

@section('scripts')
    @if(!$data->isEmpty())
        <script>
            $(document).ready(function () {
                // Setup - add a text input to each footer cell
                $('#example tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Magasin") {
                        $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                });
                // DataTable
                var table = $('#example').DataTable({
                    //"scrollY": "50px",
                    //"scrollX": true,
                    "searching": true,
                    "paging": true,
                    //"autoWidth": true,
                    "info": true,
                    stateSave: false,
                    "columnDefs": [
                        //{"width": "7%", "targets": 0, "searchable": true}
                        {"width": "20%", "targets": 1},
                        {"width": "10%", "targets": 2, "searchable": false},
                    ]
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
        #example {
            width: 100%;
            border: 0px solid #D9D5BE;
            border-collapse: collapse;
            margin: 0px;
            background: white;
            font-size: 1em;
        }

        #example td {
            padding: 10px;
        }
    </style>
@endsection

@section('menu_1') @include('Espace_Magas._nav_menu_1') @endsection
@section('menu_2') @include('Espace_Magas._nav_menu_2') @endsection
