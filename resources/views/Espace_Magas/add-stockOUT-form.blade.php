@extends('layouts.main_master')

@section('title') Stock du main magasin: {{ $magasin->libelle }}  @endsection

@section('main_content')

    <h3 class="page-header">Sortie de stock du magasin principal:
        <strong>{{ $magasin->libelle }}</strong></h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des magasins</li>
        <li class="breadcrumb-item"><a href="{{ route('magas.magasin') }}">{{ $magasin->libelle  }}</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('magas.stocks') }}">Stock</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('magas.addStockOUT') }}">sortie de stock</a></li>
    </ol>


    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                {{-- *************** form ***************** --}}
                <form role="form" name="myForm" id="myForm" method="post"
                      action="{{ Route('magas.submitAddVente') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_magasin" value="{{ $magasin->id_magasin }}"/>
                    <input type="hidden" name="type_vente" value="simple"/>

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
                            <th rowspan="2">Actions</th>

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

                            <tr {{--ondblclick="window.open('{{ Route('magas.stock',[ 'p_id' => $item->id_stock ]) }}');" --}}>


                                <td>
                                    {{ \App\Models\Article::getRef($item->id_article) }}
                                    {{ \App\Models\Article::getAlias($item->id_article)!=null ? ' - '.\App\Models\Article::getAlias($item->id_article):' ' }}
                                </td>
                                <td>{{ \App\Models\Article::getCode($item->id_article) }}</td>
                                <td>
                                    @if( App\Models\Article::getImage($item->id_article) != null)
                                        <img src="{{ asset(App\Models\Article::getImage($item->id_article)) }}"
                                             width="40px"
                                             onmouseover="overImage('{{ asset(App\Models\Article::getImage($item->id_article)) }}');"
                                             onmouseout="outImage();">
                                    @endif
                                    {{ \App\Models\Article::getDesignation($item->id_article) }}
                                </td>
                                <td>{{ \App\Models\Article::getMarque($item->id_article) }}</td>
                                <td>{{ \App\Models\Article::getCategorie($item->id_article) }}</td>
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
                                    <div class="modal fade" id="modal{{ $loop->index+1 }}" role="dialog"
                                         tabindex="-1" aria-labelledby="gridSystemModalLabel">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                    <h3 class="modal-title" id="gridSystemModalLabel">
                                                        <b>{{ \App\Models\Article::getDesignation($item->id_article) }}</b>
                                                    </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        {{-- detail article --}}
                                                        <div class="col-lg-6">
                                                            <table class="table table-striped table-bordered table-hover">
                                                                <tr>
                                                                    <td>Code</td>
                                                                    <th colspan="2">{{ \App\Models\Article::getCode($item->id_article) }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Reference</td>
                                                                    <th colspan="2">
                                                                        {{ \App\Models\Article::getRef($item->id_article) }}
                                                                        {{ \App\Models\Article::getAlias($item->id_article)!=null ? ' - '.\App\Models\Article::getAlias($item->id_article):' ' }}
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Marque</td>
                                                                    <th colspan="2">{{ \App\Models\Article::getMarque($item->id_article) }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Categorie</td>
                                                                    <th colspan="2">{{ \App\Models\Article::getCategorie($item->id_article) }}</th>
                                                                </tr>

                                                                <td>Fournisseur</td>
                                                                <th colspan="2">{{ \App\Models\Article::getFournisseur($item->id_article) }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Code</td>
                                                                    <th colspan="2">{{ \App\Models\Article::getCode($item->id_article) }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Code</td>
                                                                    <th colspan="2">{{ \App\Models\Article::getCode($item->id_article) }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Couleur</td>
                                                                    <th colspan="2">{{ \App\Models\Article::getCouleur($item->id_article) }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Sexe</td>
                                                                    <th colspan="2">{{ \App\Models\Article::getSexe($item->id_article) }}</th>
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
                                                                <tr>
                                                                    <td>Code</td>
                                                                    <th colspan="2">{{ \App\Models\Article::getCode($item->id_article) }}</th>
                                                                </tr>
                                                            </table>
                                                        </div>

                                                        {{-- tailles & quantotes --}}
                                                        <div class="col-lg-6">
                                                            @if(\App\Models\Stock_taille::hasTailles($item->id_stock))
                                                                <table class="table table-striped table-bordered table-hover">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Taille</th>
                                                                        <th>Quantite disponible</th>
                                                                        <th>Quantite a vendre</th>
                                                                    </tr>
                                                                    </thead>
                                                                    @foreach( \App\Models\Stock_taille::getTailles($item->id_stock) as $taille )
                                                                        <tr>
                                                                            <input type="hidden"
                                                                                   name="quantite[{{ $item->id_stock }}][{{ $loop->iteration }}]"
                                                                                   value="{{ $taille->quantite }}"/>

                                                                            <td align="center">{{ \App\Models\Taille_article::getTaille($taille->id_taille_article) }}</td>
                                                                            <td align="center">{{ $taille->quantite }}</td>
                                                                            <td>
                                                                                <input type="number" min="0"
                                                                                       class="form-control"
                                                                                       max="{{ $taille->quantite }}"
                                                                                       placeholder="Quantite"
                                                                                       name="quantiteOUT[{{ $item->id_stock }}][{{ $loop->iteration }}]"
                                                                                       value="{{ old('quantiteOUT.'.($item->id_stock).'.'.($loop->iteration).'') }}"
                                                                                       id="quantite_{{ $loop->parent->iteration }}_{{ $loop->iteration }}"
                                                                                       onkeyup="calcQ({{ $loop->parent->iteration }},{{ \App\Models\Stock_taille::getTailles($item->id_stock)->count() }});calcTotal({{ $data->count() }});">

                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <th colspan="2">Qts</th>
                                                                        <td><input type="number" disabled
                                                                                   class="form-control"
                                                                                   id="sommeQ_{{ $loop->iteration }}"
                                                                                   value="0"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th colspan="2">Total</th>
                                                                        <td><input type="number" name="result"
                                                                                   pattern=".##"
                                                                                   disabled
                                                                                   id="total_{{ $loop->iteration }}"
                                                                                   class="form-control"/></td>
                                                                    </tr>

                                                                </table>
                                                            @else
                                                                <h2 class="row">
                                                                    <b><i>Aucun article disponible</i></b>
                                                                </h2>
                                                            @endif
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
                                    </div>
                                    {{-- fin Modal (pour afficher les details de chaque article) --}}
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>

                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div data-toggle="modal" data-target="#squarespaceModal"
                                     class="btn btn-primary center-block">Paiement
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog"
                         aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">×</span><span class="sr-only">Fermer</span>
                                    </button>
                                    <h2 class="modal-title" id="lineModalLabel" align="center">Paiement</h2>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <table class="table table-striped table-bordered table-hover">
                                                <tr>
                                                    <th>
                                                        <label>Taux de Remise
                                                            <i class="glyphicon glyphicon-info-sign" {!! setPopOver("","Taux de la remise, si vous voullez (exemple: 15%)") !!}></i>
                                                        </label>
                                                    </th>
                                                    <td>
                                                        <input class="form-control" type="number" min="0"
                                                               placeholder="Taux" value="{{ old('taux_remise') }}"
                                                               name="taux_remise" id="taux_remise"
                                                               onkeyup="appliquerRemise();">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <label>Raison de la remise
                                                            <i class="glyphicon glyphicon-info-sign" {!! setPopOver("","Raison de la remise") !!}></i>
                                                        </label>
                                                    </th>

                                                    <td>
                                                    <textarea class="form-control" placeholder="Raison"
                                                              name="raison" cols="10"
                                                              rows="2">{{ old('raison') }}</textarea>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th>
                                                        <label>Montant sans remise</label>
                                                    </th>
                                                    <td>
                                                        <input type="number" name="result" pattern=".##"
                                                               disabled onchange=""
                                                               id="total_prix"
                                                               class="form-control"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><label>Montant avec remise</label></th>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="number" pattern=".##" class="form-control"
                                                                   placeholder="Montant total" id="montant"
                                                                   aria-describedby="basic-addon1" disabled>
                                                            <span class="input-group-addon" id="basic-addon1">Dhs</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-6">
                                            <table id="myTable" class="table table-striped table-bordered table-hover">
                                                <tr>
                                                    <th>
                                                        <label {!! setPopOver("Obligatoire","Sélectionnez le mode de paiement") !!}>Mode
                                                            de Paiement *</label>
                                                    </th>
                                                    <td>
                                                        <select class="form-control" name="id_mode_paiement">
                                                            @foreach( $modes_paiement as $mode )
                                                                <option value="{{$mode->id_mode_paiement }}" {{$mode->id_mode=="2" ? 'selected' : '' }}>{{$mode->libelle }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>
                                                        <label {!! setPopOver("","saisissez la reference du cheque. (si paiement est effectué par par cheque") !!}>Reference
                                                            chequier</label>
                                                    </th>
                                                    <td>
                                                        <input class="form-control" type="text" placeholder="ref"
                                                               name="ref"
                                                               value="{{ old('ref') }}">
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"
                                                    role="button">Fermer
                                            </button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <!--button type="button" id="saveImage" class="btn btn-default btn-hover-green"
                                                    data-action="save" role="button">Save
                                            </button-->
                                            <input type="submit" value="Valider la vente" formtarget="_blank"
                                                   class="btn btn-outline btn-success">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
