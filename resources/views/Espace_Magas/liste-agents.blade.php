@extends('layouts.main_master')

@section('title') Agents @endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Liste des agents</h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item ">Gestion des Articles</li>
                    <li class="breadcrumb-item active">Liste des agents</li>
                </ol>



            <!-- Table responsive -->
                <div class="table-responsive">
                    <div class="col-lg-12">
                        <table id="example" class="table table-striped table-hover">
                            <thead bgcolor="#DBDAD8">
                            <tr>
                                <th>#</th>
                                <th><i class="fa fa-fw fa-sort"></i> Fournisseur</th>
                                <th><i class="fa fa-fw fa-sort"></i> Nom et prenom</th>
                                <th><i class="fa fa-fw fa-sort"></i> Role</th>
                                <th><i class="fa fa-fw fa-sort"></i> Email</th>
                                <th>Autres</th>
                            </tr>
                            </thead>
                            <tfoot bgcolor="#DBDAD8">
                            <tr>
                                <th></th>
                                <th>Fournisseur</th>
                                <th>Nom et prenom</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                            </tfoot>

                            <tbody>
                            @if( $data->isEmpty() )
                                <tr>
                                    <td></td>
                                    <td align="center">Aucun agent</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @else
                                @foreach( $data as $item )
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ \App\Models\Fournisseur::getLibelle($item->id_fournisseur) }}</td>
                                        <td>{{ $item->nom }} {{ $item->prenom }} </td>
                                        <td>{{ $item->role }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            <div class="btn-group pull-right">
                                                <button type="button"
                                                        class="btn green btn-sm btn-outline dropdown-toggle"
                                                        data-toggle="dropdown">
                                                    <span {!! setPopOver("","Clisuez ici pour afficher les actions") !!}>Actions</span>
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu pull-left" role="menu">
                                                    <li>
                                                        <a href="{{ Route('magas.info',['p_table'=> 'agents', 'p_id' => $item->id_agent ]) }}"
                                                           title="detail"><i class="glyphicon glyphicon-eye-open"></i>
                                                            Plus de detail
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ Route('magas.update',['p_table'=> 'agents', 'p_id' => $item->id_agent ]) }}"
                                                           title="modifier"><i class="glyphicon glyphicon-pencil"></i>
                                                            Modifier</a>
                                                    </li>
                                                    <li>
                                                        <a onclick="return confirm('Êtes-vous sure de vouloir effacer le Fournisseur: {{ $item->nom }} {{ $item->prenom }} ?')"
                                                           href=""
                                                           title="effacer"><i class="glyphicon glyphicon-trash"></i>
                                                            Effacer</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a data-toggle="modal"
                                                           data-target="#myModal{{ $loop->index+1 }}"><i
                                                                    {!! setPopOver("","Afficher plus de detail") !!} class="glyphicon glyphicon-info-sign"></i>
                                                            visualiser</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>

                                        {{-- Modal (pour afficher les details de chaque article) --}}
                                        <div class="modal fade" id="myModal{{ $loop->index+1 }}" role="dialog">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            &times;
                                                        </button>
                                                        <h4 class="modal-title">{{ $item->role }}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>
                                                            <b>Fournisseur</b> {{ \App\Models\Fournisseur::getLibelle($item->id_fournisseur) }}
                                                        </p>
                                                        <p><b>Nom</b> {{ $item->nom }}</p>
                                                        <p><b>Prenom</b> {{ $item->prenom }}</p>
                                                        <p><b>Email</b> {{ $item->email }}</p>
                                                        <p><b>Telephone</b> {{ $item->telephone }}</p>
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
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.Table responsive -->

                <!-- row Buttons -->
                <div class="row" align="center">
                    <a href="{{ Route('magas.add',[ 'p_table' => 'agents' ]) }}" type="button"
                       class="btn btn-outline btn-default"> <i class="glyphicon glyphicon-plus "></i> Ajouter un
                        agent </a>
                </div>
                <!-- /.row Buttons -->

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function () {
                var title = $(this).text();
                if (title == "Nom et prenom") {
                    $(this).html('<input type="text" size="20" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                else if (title == "Fournisseur") {
                    $(this).html('<input type="text" size="20" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                else if (title == "Email") {
                    $(this).html('<input type="text" size="18" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                else if (title == "Role") {
                    $(this).html('<input type="text" size="12" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                else if (title != "") {
                    $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
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
                    {"width": "02%", "targets": 0, "type": "num", "visible": true, "searchable": false},
                    //{"width": "30%", "targets": 1, "type": "string", "visible": true},
                    {"width": "30%", "targets": 2, "type": "string", "visible": true},
                    {"width": "20%", "targets": 3, "type": "string", "visible": true},
                    {"width": "20%", "targets": 4, "type": "string", "visible": true},
                    {"width": "10%", "targets": 5, "type": "string", "visible": true}
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

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection