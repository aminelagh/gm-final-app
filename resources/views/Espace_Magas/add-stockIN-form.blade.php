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


                    @foreach( $data as $item )
                        <input type="hidden" name="id_stock[{{ $loop->index+1 }}]" value="{{ $item->id_stock }}"/>

                        {{-- Container --}}
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><b>{{ \App\Models\Article::getDesignation($item->id_article) }}</b></h4>
                            </div>

                            <div class="panel-body">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#article_{{ $loop->index+1 }}" data-toggle="tab">Article</a>
                                    </li>
                                    <li>
                                        <a href="#stock_{{ $loop->index+1 }}" data-toggle="tab">Stock</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="article_{{ $loop->index+1 }}">
                                        <table class="table table-striped table-bordered table-hover">
                                            <tr>
                                                <td align="right">Marque</td>
                                                <th>{{ \App\Models\Article::getMarque($item->id_article) }}</th>
                                                <td align="right">Categorie</td>
                                                <th>{{ \App\Models\Article::getCategorie($item->id_article) }}</th>
                                                <td align="right">Fournisseur</td>
                                                <th>{{ \App\Models\Article::getFournisseur($item->id_article) }}</th>
                                            </tr>
                                            <tr>
                                                <td align="right">Code</td>
                                                <th>{{ \App\Models\Article::getCode($item->id_article) }}</th>
                                                <td align="right">Reference</td>
                                                <th>{{ \App\Models\Article::getRef($item->id_article) }}
                                                    {{ \App\Models\Article::getAlias($item->id_article)!=null ? ' - '.\App\Models\Article::getAlias($item->id_article) : '' }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td align="right">Couleur</td>
                                                <th>{{ \App\Models\Article::getCouleur($item->id_article) }}</th>
                                                <td align="right">Sexe</td>
                                                <th>{{ \App\Models\Article::getSexe($item->id_article) }}</th>
                                                <td align="right">Prix</td>
                                                <th align="right">{{ \App\Models\Article::getPrixTTC($item->id_article) }}
                                                    Dhs
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="stock_{{ $loop->index+1 }}">
                                        <table id="example_{{$loop->index+1}}"
                                               class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Taille</th>
                                                <th>Quantite disponible</th>
                                                <th>Quantite a ajouter</th>
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
                        </div>
                        {{-- /.Container --}}

                        <script type="text/javascript" charset="utf-8">
                            $(document).ready(function () {

                                var t_{{$loop->index+1}} = $('#example_{{$loop->index+1}}').DataTable({
                                    "ordering": false,
                                    "paging": false,
                                    "searching": false,
                                    "info": true,
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
                                        /*t_{{$loop->index+1}}.row.add([
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
    <script>
    </script>
@endsection
