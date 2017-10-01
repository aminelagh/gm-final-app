@extends('layouts.main_master')

@section('title') Categories @endsection

@section('main_content')
    <h1 class="page-header">Categories </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des Articles</li>
        <li class="breadcrumb-item active">Liste des categories</li>
    </ol>



    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="example" class="table table-striped table-bordered table-hover">
                    <thead bgcolor="#DBDAD8">
                    <tr>

                        <th>Categorie</th>
                        <th>Details</th>
                    </tr>
                    </thead>
                    <tfoot bgcolor="#DBDAD8">
                    <tr>

                        <th>Categorie</th>
                        <th></th>
                    </tr>
                    </tfoot>

                    <tbody>

                    @if( $data->isEmpty() )
                        <tr>
                            <td></td>
                            <td align="center"><i>Aucune categorie</i></td>
                            <td></td>
                        </tr>
                    @else
                        @foreach( $data as $item )
                            <tr class="odd gradeA">

                                <td><a href="{{ route('magas.categorie',[ $item->id_categorie]) }}"> {{$item->libelle}}</a></td>
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
                                                    <h4 class="modal-title">{{ $item->libelle }}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        <tr>
                                                            <td>Libelle</td>
                                                            <th>{{ $item->libelle }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Date de création</td>
                                                            <th>{{ getDateHelper($item->created_at) }}
                                                                a {{ getTimeHelper($item->created_at) }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Date de denière modification</td>
                                                            <th>{{ getDateHelper($item->updated_at) }}
                                                                a {{ getTimeHelper($item->updated_at) }}</th>
                                                        </tr>

                                                    </table>

                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-lg-4">
                                                        <form action="{{ route('magas.deleteCategorie',[$item->id_categorie]) }}" method="post">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit" class="btn btn-danger btn-outline">
                                                                Supprimer
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <a href="{{ route('magas.categorie',[$item->id_categorie]) }}"
                                                           class="btn btn-info btn-outline">
                                                            Modifier
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <button type="button" class="btn btn-info btn-outline"
                                                                data-dismiss="modal">
                                                            Fermer
                                                        </button>

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

    <!-- row -->
    <div class="row" align="center">
        <a href="{{ Route('magas.addCategorie') }}" type="button"
           class="btn btn-outline btn-default" {!! setPopOver("","Ajouter une nouvelle categorie") !!}>
            <i class="glyphicon glyphicon-plus "></i> Ajouter une categorie</a>
    </div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function () {
                var title = $(this).text();
                if (title == "Marque") {
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
                    {"width": "10%", "targets": 0},
                    //{"width": "30%", "targets": 1},
                    {"width": "05%", "targets": 1},
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
@endsection

@section('menu_1') @include('Espace_Magas._nav_menu_1') @endsection
@section('menu_2') @include('Espace_Magas._nav_menu_2') @endsection
