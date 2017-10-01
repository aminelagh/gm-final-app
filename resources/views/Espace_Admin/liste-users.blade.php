@extends('layouts.main_master')

@section('title') Utlisateurs @endsection

@section('main_content')
    <h3 class="page-header">Liste des utilisateurs</h3>

    {{-- div Table --}}
    <div class="table-responsive">
        <div class="col-lg-12">
            <table id="example" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Role</th>
                    <th>Nom et Prenom</th>
                    <th>Ville</th>
                    <th>Email</th>
                    <th>Magasin</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Role</th>
                    <th>Nom et Prenom</th>
                    <th>Ville</th>
                    <th>Email</th>
                    <th>Magasin</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @if( $data->isEmpty() )
                    <tr>
                        <td colspan="7" align="center">Aucun employe</td>
                    </tr>
                @else
                    @foreach( $data as $item )
                        <tr ondblclick="window.open('{{ route('admin.user',[ $item->id ]) }}');">
                            <td>{{ $item->name }}</td>
                            <td>
                                <a href="{{ route('admin.user',[ $item->id]) }}"> {{ $item->nom }} {{ $item->prenom }}</a>
                            </td>
                            <td>{{ $item->ville }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <a href="{{ route('admin.magasin',[ $item->id_magasin]) }}"> {!! $item->libelle!=null ? $item->libelle : '<i>Aucun</i>'   !!}</a>
                            </td>
                            <td align="center">

                                <a data-toggle="modal" data-target="#modal{{ $loop->iteration }}"><i
                                            class="glyphicon glyphicon-info-sign"
                                            aria-hidden="false"></i></a>

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
                                                    <b>{{ $item->nom }} {{ $item->prenom }}</b></h3>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-striped  table-hover">
                                                    <tr>
                                                        <td>Role</td>
                                                        <th>{{ $item->name }}</th>
                                                    </tr>
                                                    @if($item->id_magasin!=null)
                                                        <tr>
                                                            <td>Magasin</td>
                                                            <th>{{ $item->libelle }}</th>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td>Email</td>
                                                        <th>{{ $item->email }}</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Ville</td>
                                                        <th>{{ $item->ville }}</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Telephone</td>
                                                        <th>{{ $item->email }}</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Derniere connexion</td>
                                                        <th>{{ getDateHelper($item->last_login) }}</th>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-lg-4">
                                                    <form action="{{ route('admin.deleteUser',[$item->id]) }}"
                                                          method="post">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger btn-outline">
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="col-lg-4">
                                                    <a href="{{ route('admin.user',[$item->id]) }}"
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
                                {{-- fin Modal (pour afficher les details de chaque article) --}}
                            </td>
                        </tr>

                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="row" align="center">
        <a href="{{ Route('admin.addUser') }}" type="button"
           class="btn btn-outline btn-default" {!! setPopOver("","Créer un nouvel utilisateur") !!}> Ajouter un
            utilisateur</a>
    </div>
@endsection

@section('scripts')
    @if( !$data->isEmpty() )
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function () {

                var table = $('#example').DataTable({
                    //"scrollY": "50px",
                    //"scrollX": true,
                    "searching": true,
                    "paging": true,
                    //"autoWidth": true,
                    "info": true,
                    stateSave: false,
                    "columnDefs": [
                        {"width": "05%", "targets": 0, "type": "string", "visible": true},
                        {"width": "05%", "targets": 1, "type": "string", "visible": true},
                        {"width": "08%", "targets": 2, "type": "string", "visible": true},
                        //{"width": "08%", "targets": 3, "type": "string", "visible": true},
                        {"width": "08%", "targets": 4, "type": "string", "visible": true},
                        {"width": "05%", "targets": 5, "type": "string", "visible": true, "searchable": false}
                    ]
                });


                // Setup - add a text input to each footer cell
                $('#example tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Role" || title == "Ville") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Nom et Prenom" || title == "Fournisseur" || title == "Marque") {
                        $(this).html('<input type="text" size="11" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
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

        #example {
            width: 100%;
            border: 0px solid #D9D5BE;
            border-collapse: collapse;
            margin: 0px;
            background: white;
            font-size: 1em;
        }

        #example td {
            padding: 5px;
        }
    </style>
@endsection

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection
