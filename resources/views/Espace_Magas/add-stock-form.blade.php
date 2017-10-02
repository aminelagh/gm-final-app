@extends('layouts.main_master')

@section('title') Création de Stock du magasin {{ $magasin->libelle }} @endsection

@section('main_content')
    <h3 class="page-header">Création du stock du magasin: <strong>{{ $magasin->libelle }}</strong></h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des magasins</li>
        <li class="breadcrumb-item"><a href="{{ Route('magas.magasins') }}">Liste des magasins</a></li>
        <li class="breadcrumb-item">{{ $magasin->libelle }}</li>
        <li class="breadcrumb-item active">Création du stock</li>
    </ol>


    <div class="row">
        @if( !$articles->isEmpty() )
            <div class="breadcrumb">
                Afficher/Masquer:
                <a class="toggle-vis" data-column="0">Reference</a> -
                <a class="toggle-vis" data-column="1">Code</a> -
                <a class="toggle-vis" data-column="2">Designation</a> -
                <a class="toggle-vis" data-column="3">Categorie</a> -
                <a class="toggle-vis" data-column="4">Fournisseur</a> -
                <a class="toggle-vis" data-column="5">Marque</a> -
                <a class="toggle-vis" data-column="6">Couleur</a> -
                <a class="toggle-vis" data-column="7">Sexe</a> -
                <a class="toggle-vis" data-column="8">Prix</a>
            </div>
        @endif
    </div>
    <hr>

    <!-- Row 1 -->
    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                {{-- *************** form ***************** --}}
                <form role="form" name="myForm" id="myForm" method="post" action="{{ Route('magas.submitAddStock') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_magasin" value="{{ $magasin->id_magasin }}"/>

                    <table id="example" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>

                            <th>Reference</th>
                            <th>Code</th>

                            <th>Designation</th>

                            <th>Categorie</th>
                            <th>Fournisseur</th>
                            <th>Marque</th>

                            <th>Couleur</th>
                            <th>Sexe</th>

                            <th>Prix</th>
                            <th>Quantité min</th>
                            <th>Quantité max</th>
                            <th>Details</th>
                        </tr>
                        </thead>
                        @if( !$articles->isEmpty() )
                            <tfoot>
                            <tr>
                                <th>Reference</th>
                                <th>Code</th>
                                <th>Designation</th>
                                <th>Categorie</th>
                                <th>Fournisseur</th>
                                <th>Marque</th>
                                <th>Couleur</th>
                                <th>Sexe</th>
                                <th>Prix</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                        @endif
                        <tbody>
                        @if( !$articles->isEmpty() )
                            @foreach( $articles as $item )
                                <tr>
                                    <input type="hidden" name="id_article[{{ $loop->index+1 }}]"
                                           value='{{ $item->id_article }}'>

                                    <input type="hidden" name="designation[{{ $loop->index+1 }}]"
                                           value="{{ $item->designation }}">


                                    <td align="right">{{ $item->ref }} {{ $item->alias!=null? ' - '.$item->alias : '' }}</td>
                                    <td align="right">{{ $item->code }}</td>

                                    <td>{{ $item->designation }}</td>

                                    <td>{{ $item->libelle_c }}</td>
                                    <td>{{ $item->libelle_f }}</td>
                                    <td>{!! $item->libelle_m !!}</td>

                                    <td>{{ $item->couleur }}</td>
                                    <td>{{ $item->sexe }}</td>

                                    <td align="right">{{ $item->prix_v }} DH</td>
                                    <td><input type="number" min="0" class="form-control" placeholder="Quantite Min" name="quantite_min[{{ $loop->index+1 }}]"
                                               value="{{ old('quantite_min.'.($loop->index+1) ) }}"></td>
                                    <td><input type="number" min="0" class="form-control" placeholder="Quantite Max" name="quantite_max[{{ $loop->index+1 }}]"
                                               value="{{ old('quantite_max.'.($loop->index+1)) }}"></td>
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
                                                        <h4 class="modal-title">{{ $item->designation }}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-striped table-bordered table-hover">
                                                            <tr>
                                                                <td>Reference</td>
                                                                <th>{{ $item->ref }} - {{ $item->alias }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Code</td>
                                                                <th>{{ $item->code }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Marque</td>
                                                                <th>{{ \App\Models\Article::getMarque($item->id_article) }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Categorie</td>
                                                                <th>{{ \App\Models\Article::getCategorie($item->id_article) }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Fournisseur</td>
                                                                <th>{{ \App\Models\Article::getFournisseur($item->id_article) }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Couleur</td>
                                                                <th>{{ $item->couleur }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Sexe</td>
                                                                <th>{{ $item->sexe }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" align="center">Prix d'achat</td>
                                                            </tr>
                                                            <tr>
                                                                <th align="right">{{ \App\Models\Article::getPrixAchatHT($item->id_article) }}
                                                                    Dhs HT
                                                                </th>
                                                                <th>{{ \App\Models\Article::getPrixAchatTTC($item->id_article) }}
                                                                    Dhs TTC
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" align="center">Prix de vente</td>
                                                            </tr>
                                                            <tr>
                                                                <th align="right">{{ \App\Models\Article::getPrixHT($item->id_article) }}
                                                                    Dhs HT
                                                                </th>
                                                                <th>{{ \App\Models\Article::getPrixTTC($item->id_article) }}
                                                                    Dhs TTC
                                                                </th>
                                                            </tr>
                                                        </table>
                                                        @if( $item->image != null) <img
                                                                src="{{ asset($item->image) }}"
                                                                width="150px">@endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="col-lg-4">
                                                            <a href="{{ route('magas.article',[$item->id_article]) }}"
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

                    <div class="row" align="center">
                        <button data-toggle="popover" data-placement="top" data-trigger="hover"
                                title="Valider l'ajout"
                                data-content="Cliquez ici pour valider la création du stock avec l'ensemble des articles choisi"
                                type="submit" name="submit" value="valider" class="btn btn-default">Valider
                        </button>
                    </div>

                </form>
                {{-- *************** end form ***************** --}}
            </div>
        </div>
    </div>
    <br>
    <hr>

@endsection

@section('scripts')
    @if(!$articles->isEmpty())
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function () {
                // Setup - add a text input to each footer cell
                $('#example tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Reference" || title == "Code") {
                        $(this).html('<input type="text" size="6" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Categorie" || title == "Fournisseur" || title == "Marque") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Designation") {
                        $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Couleur" || title == "Sexe") {
                        $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Prix") {
                        $(this).html('<input type="text" size="4" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                });

                var table = $('#example').DataTable({
                    //"pageLength": 25,
                    "searching": true,
                    "paging": true,
                    //"info": true,
                    stateSave: false,
                    "columnDefs": [
                        {"width": "04%", "targets": 0, "type": "num", "visible": true, "searchable": true},//#
                        {"width": "05%", "targets": 1, "type": "string", "visible": true},
                        {"width": "05%", "targets": 2, "type": "string", "visible": true},

                        {"width": "08%", "targets": 3, "type": "string", "visible": false},
                        {"width": "08%", "targets": 4, "type": "string", "visible": false},
                        {"width": "08%", "targets": 5, "type": "string", "visible": false},

                        {"width": "02%", "targets": 6, "type": "string", "visible": false},

                        {"width": "02%", "targets": 7, "type": "string", "visible": false},
                        {"width": "06%", "targets": 8, "type": "string", "visible": false},

                        {"width": "04%", "targets": 9, "visible": true, "searchable": false},
                        {"width": "04%", "targets": 10, "visible": true, "searchable": false},
                        {"width": "04%", "targets": 11, "visible": true, "searchable": false}
                    ],
                });


                $('#myForm').on('submit', function (e) {
                    var form = this;

                    // Encode a set of form elements from all pages as an array of names and values
                    var params = table.$('input,select,textarea').serializeArray();

                    // Iterate over all form elements
                    $.each(params, function () {
                        // If element doesn't exist in DOM
                        if (!$.contains(document, form[this.name])) {
                            // Create a hidden element
                            $(form).append(
                                    $('<input>')
                                            .attr('type', 'hidden')
                                            .attr('name', this.name)
                                            .val(this.value)
                            );
                        }
                    });
                });


                /*$('#myForm').on('submit',function(e){
                 var form = this;
                 var rowsel = table.column(0).checkboxes.selected();
                 $.each(rowsel, function(index, rowId){
                 $(form).append(
                 $('<input>').attr('type','hidden').attr('name','id[]').val(rowId)
                 );
                 $("#view-rows").text(rowsel.join(","))
                 $("#view-form").text($(form).serialize())
                 $('input[name="id\[\]"]', form).remove()
                 e.preventDefault()

                 });
                 });*/


                //-------------------------------------------------
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

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection
