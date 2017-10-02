@extends('layouts.main_master')

@section('title') Stock du main magasin: {{ $magasin->libelle }}  @endsection

@section('main_content')

    <h3 class="page-header">Entrée de stock du magasin principal:
        <strong>{{ $magasin->libelle }}</strong></h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des magasins</li>
        <li class="breadcrumb-item"><a href="{{ route('magas.magasin') }}">{{ $magasin->libelle  }}</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('magas.stocks') }}">Stock</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('magas.addStockIN') }}">entree de stock</a></li>
    </ol>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">

                {{-- *************** form ***************** --}}
                <form role="form" name="myForm" id="myForm" method="post"
                      action="{{ Route('magas.submitAddStockIN') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_magasin" value="{{ $magasin->id_magasin }}"/>


                    {{-- Table Begin --}}
                    <table id="myTable" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th rowspan="2">Reference</th>
                            <th rowspan="2">Code</th>
                            <th rowspan="2">Designation</th>
                            <th rowspan="2">Marque</th>
                            <th rowspan="2">Categorie</th>
                            <th colspan="2">Prix de gros</th>
                            <th colspan="2">Prix</th>
                            <th rowspan="2">Etat</th>
                            <th rowspan="2"></th>
                        </tr>
                        <tr>
                            <th>HT</th>
                            <th>TTC</th>
                            <th>HT</th>
                            <th>TTC</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Reference</th>
                            <th>Code</th>
                            <th>Designation</th>
                            <th>Marque</th>
                            <th>Categorie</th>
                            <th>HT</th>
                            <th>TTC</th>
                            <th>HT</th>
                            <th>TTC</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                        <tbody>

                        @foreach( $data as $item )

                            <tr>
                                <input type="hidden" name="id_stock[{{ $loop->iteration }}]" value="{{ $item->id_stock }}"/>
                                <td>
                                    {{ $item->ref }}
                                    {{ $item->alias!=null ? ' - '.$item->alias:' ' }}
                                </td>
                                <td>{{ $item->code }}</td>
                                <td>
                                    @if( $item->image != null)
                                        <img src="{{ asset($item->image) }}" width="40px"
                                             onmouseover="overImage('{{ asset($item->image) }}');" onmouseout="outImage();">
                                    @endif
                                    {{ $item->designation }}
                                </td>
                                <td>{{ $item->libelle_m }}</td>
                                <td>{{ $item->libelle_c }}</td>
                                <td align="right">{{ \App\Models\Article::getPrixHT($item->id_article) }}</td>
                                <td align="right">
                                    <div id="prix_{{ $loop->iteration }}"
                                         title="{{ \App\Models\Article::getPrixTTC($item->id_article) }}">{{ \App\Models\Article::getPrixTTC($item->id_article) }}</div>
                                </td>
                                <td align="right">{{ \App\Models\Article::getPrixHT($item->id_article) }}</td>
                                <td align="right">{{ \App\Models\Article::getPrixTTC($item->id_article) }}</td>
                                <td align="center">
                                    @if(\App\Models\Stock::getState($item->id_stock) == 0)
                                        <div id="circle"
                                             style="background: darkred;" {!! setPopOver("indisponible",\App\Models\Stock::getNombreArticles($item->id_stock)." article") !!}></div>
                                    @elseif(\App\Models\Stock::getState($item->id_stock) == 1)
                                        <div id="circle"
                                             style="background: red;" {!! setPopOver("",\App\Models\Stock::getNombreArticles($item->id_stock)." article(s)") !!}></div>
                                    @elseif(\App\Models\Stock::getState($item->id_stock) == 2)
                                        <div id="circle"
                                             style="background: orange;" {!! setPopOver("",\App\Models\Stock::getNombreArticles($item->id_stock)." article(s)") !!}></div>
                                    @elseif(\App\Models\Stock::getState($item->id_stock) == 3)
                                        <div id="circle"
                                             style="background: lawngreen;" {!! setPopOver("Disponible",\App\Models\Stock::getNombreArticles($item->id_stock)." article(s)") !!}></div>
                                    @endif
                                </td>

                                <td align="center">
                                    <div class="btn btn-outline btn-success" data-toggle="modal"
                                         data-target="#modal{{ $loop->index+1 }}">Tailles
                                    </div>
                                    {{-- Modal (pour afficher les details de chaque article) --}}
                                    <div class="modal fade" id="modal{{ $loop->iteration }}" role="dialog"
                                         tabindex="-1" aria-labelledby="gridSystemModalLabel">
                                        <div class="modal-dialog modal-lg">
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
                                                    <div class="row">
                                                        {{-- detail article --}}
                                                        <div class="col-lg-6">
                                                            <h4>Details article</h4>
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
                                                                    <td>Prix de vente</td>
                                                                    <th>{{ \App\Models\Article::getPrixHT($item->id_article) }}
                                                                        Dhs HT
                                                                    </th>
                                                                    <th>
                                                                        {{ \App\Models\Article::getPrixTTC($item->id_article) }}
                                                                        Dhs TTC
                                                                    </th>
                                                                </tr>
                                                            </table>

                                                            {{-- tailles & quantotes --}}

                                                            @if(\App\Models\Stock_taille::hasTailles($item->id_stock))
                                                                <h4>Diponible dans le stock</h4>
                                                                <table class="table table-striped table-bordered table-hover">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Taille</th>
                                                                        <th>Quantité disponible</th>
                                                                    </tr>
                                                                    </thead>
                                                                    @foreach( \App\Models\Stock_taille::getTailles($item->id_stock) as $taille )
                                                                        <tr>
                                                                            <input type="hidden"
                                                                                   name="quantite[{{ $item->id_stock }}][{{ $loop->iteration }}]"
                                                                                   value="{{ $taille->quantite }}"/>
                                                                            <input type="hidden"
                                                                                   name="id_taille_article[{{ $item->id_stock }}][{{ $loop->index+1 }}]"
                                                                                   value="{{ $taille->id_taille_article }}"/>

                                                                            <td align="center">{{ \App\Models\Taille_article::getTaille($taille->id_taille_article) }}</td>
                                                                            <td align="center">{{ $taille->quantite }}</td>
                                                                        </tr>
                                                                    @endforeach

                                                                </table>
                                                            @else
                                                                <h4 class="row"><b><i>Aucun article disponible</i></b></h4>
                                                            @endif

                                                        </div>

                                                        <div class="col-lg-6">
                                                            {{-- Table add Taille --}}
                                                            <h4>Ajouter au stock</h4>
                                                            <table id="example_{{ $loop->iteration }}"
                                                                   class="table table-striped table-bordered table-hover">
                                                                <thead>
                                                                <tr>
                                                                    <th>Taille</th>
                                                                    <th>Quantité disponible</th>
                                                                    <th>Quantité a ajouter</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if( \App\Models\Stock_taille::hasTailles($item->id_stock))

                                                                    @foreach( \App\Models\Stock_taille::getTailles($item->id_stock) as $taille )
                                                                        <tr>
                                                                            <input type="hidden"
                                                                                   name="id_taille_article[{{ $item->id_stock }}][{{ $loop->index+1 }}]"
                                                                                   value="{{ $taille->id_taille_article }}"/>

                                                                            <td align="right">{{ \App\Models\Taille_article::getTaille($taille->id_taille_article) }}</td>
                                                                            <td align="right">{{ $taille->quantite }}</td>
                                                                            <td><input type="number" min="0" placeholder="Quantite"
                                                                                       width="5" class="form-control"
                                                                                       name="quantiteIN[{{ $item->id_stock }}][{{ $loop->index+1 }}]"
                                                                                       value="{{ old('quantiteIN.'.($item->id_stock).'.'.($loop->index+1).'') }}">
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif

                                                                </tbody>
                                                                <tfoot>
                                                                <td colspan="3" align="center">
                                                                    <button id="addRow_{{ $loop->index+1 }}"
                                                                            form="NotFormSubmiForm"
                                                                            class="btn btn-outline btn-primary btn-sm"
                                                                            {!! $loop->index==0 ?  setPopOverDown("","Cliquez ici pour ajouter une nouvelle taille pour cet article") : setPopOver("","Cliquez ici pour ajouter une nouvelle taille pour cet article") !!}>
                                                                        Ajouter une taille
                                                                    </button>
                                                                </td>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">
                                                        Fermer
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>



                            <script type="text/javascript" charset="utf-8">
                                $(document).ready(function () {

                                    var t_{{$loop->index+1}}             = $('#example_{{$loop->index+1}}').DataTable({
                                        "ordering": false,
                                        "paging": false,
                                        "searching": false,
                                        "info": false,
                                        "language": {
                                            "emptyTable": "Aucune taille n'est disponible, pour ajouter des tailles cliquez sur le bouton en dessous",
                                            "lengthMenu": "Display _MENU_ records per page",
                                            "zeroRecords": "Nothing found - sorry",
                                            "info": "Showing page _PAGE_ of _PAGES_",
                                            "infoEmpty": "No records available",
                                            "infoFiltered": "(filtered from _MAX_ total records)"
                                        },
                                    });
                                    var counter = 1;

                                    $('#addRow_{{ $loop->index+1 }}').on('click', function () {

                                        @if( \App\Models\Stock_taille::hasTailles($item->id_stock))

                                        if (counter === 1) {
                                            counter = {{ count(\App\Models\Stock_taille::getTailles($item->id_stock))+1 }};
                                        }

                                        t_{{$loop->index+1}}.row.add([
                                            '<select name="id_taille_article[{{ $item->id_stock }}][' + counter + ']" class="form-control" form="myForm">' +
                                            @foreach($tailles as $taille)
                                                '<option value="{{ $taille->id_taille_article }}">{{ $taille->taille }}</option>' +
                                            @endforeach
                                                '</select>',
                                            '0',
                                            '<input type="number" min="0" placeholder="Quantite" width="5" ' +
                                            'class="form-control" name="quantiteIN[{{ $item->id_stock }}][' + counter + ']" ' +
                                            'value="">'
                                        ]).draw(false);

                                        @else

                                        if (counter == 1) {
                                            /*t_
                                            {{$loop->index+1}}.row.add([
                                             '<b>Taille</b>',
                                             '<b>Quantite in</b>'
                                             ]).draw(false);*/
                                        }

                                        t_{{$loop->index+1}}.row.add([
                                            '<select name="id_taille_article[{{ $item->id_stock }}][' + counter + ']" class="form-control">' +
                                            @foreach($tailles as $taille)
                                                '<option value="{{ $taille->id_taille_article }}">{{ $taille->taille }}</option>' +
                                            @endforeach
                                                '</select>',
                                            '0',
                                            '<input type="number" min="0" placeholder="Quantite IN" width="5" ' +
                                            'class="form-control" name="quantiteIN[{{ $item->id_stock }}][' + counter + ']" ' +
                                            'value="">',
                                        ]).draw(false);


                                        @endif
                                            counter++;
                                    });

                                    //$('#addRow_{{$loop->index+1}}').click();

                                    //popover
                                    $('[data-toggle="popover"]').popover();
                                });
                            </script>

                        @endforeach
                    </table>

                    <div class="row" align="center">
                        <input type="submit" value="Valider l'entrée de stock" class="btn btn-outline btn-success">
                    </div>

                </form>

            </div>
        </div>
    </div>

    <br/>

    <hr/>
    <br/>
@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection


@section('scripts')
    @if(!$data->isEmpty())
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function () {
                // Setup - add a text input to each footer cell
                $('#myTable tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Reference" || title == "Code") {
                        $(this).html('<input type="text" size="10" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Categorie" || title == "Marque") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Designation") {
                        $(this).html('<input type="text" size="10" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "HT" || title == "TTC") {
                        $(this).html('<input type="text" size="2" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Prix d'achat" || title == "Prix de vente") {
                        $(this).html('<input type="text" size="4" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                });


                var table = $('#myTable').DataTable({
                    "lengthMenu": [[10, 20, 30, 50, -1], [10, 20, 30, 50, "Tout"]],
                    "searching": true,
                    "paging": true,
                    "info": false,
                    stateSave: false,
                    "columnDefs": [
                        //{"visible": true, "targets": -1},
                        {"width": "04%", "targets": 0, "type": "num", "visible": true, "searchable": false}, //#
                        {"width": "05%", "targets": 1, "type": "string", "visible": true},  //ref
                        //{"width": "05%", "targets": 2, "type": "string", "visible": true},  //code

                        {"width": "05%", "targets": 3, "type": "string", "visible": true},    //desi
                        {"width": "08%", "targets": 4, "type": "string", "visible": false},     //Marque
                        {"width": "08%", "targets": 5, "type": "string", "visible": false},     //caegorie

                        {"width": "02%", "targets": 6, "type": "string", "visible": true},      //HT
                        {"width": "02%", "targets": 7, "type": "num-fmt", "visible": true},     //TTC
                        {"width": "02%", "targets": 8, "type": "string", "visible": true},      //HT
                        {"width": "02%", "targets": 9, "type": "num-fmt", "visible": true},     //TTC

                        //{"width": "05%", "targets": 10, "type": "num-fmt", "visible": true},     //etat

                        {"width": "04%", "targets": 10, "type": "num-fmt", "visible": true, "searchable": false}
                    ],
                    "select": {
                        items: 'column'
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

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection

@section('styles')
    <style>
        #circle {
            width: 15px;
            height: 15px;
            -webkit-border-radius: 25px;
            -moz-border-radius: 25px;
            border-radius: 25px;
        }

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
