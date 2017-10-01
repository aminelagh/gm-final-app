@extends('layouts.main_master')

@section('title') {{ $magasin_source->libelle }}  @endsection

@section('main_content')

    <h3 class="page-header">Transfert vers le magasin principal: <strong>{{ $magasin_destination->libelle }}</strong>
    </h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des magasins</li>
        <li class="breadcrumb-item"><a href="{{ Route('magas.magasins') }}">Liste des magasins</a></li>
        <li class="breadcrumb-item">
            <a href="{{ Route('magas.magasin',['p_id'=> $magasin_source->id_magasin]) }}">{{ $magasin_source->libelle }}</a>
        </li>
        <li class="breadcrumb-item active">Transfert depuis le magasin: <strong>{{ $magasin_source->libelle }}</strong>
        </li>
    </ol>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">

                {{-- *************** form ***************** --}}
                <form role="form" name="myForm" id="myForm" method="post"
                      action="{{ Route('magas.submitAddStockTransfertIN') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_magasin_source" value="{{ $magasin_source->id_magasin }}"/>

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
                                                    <th>Quantite a transferer</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if( \App\Models\Stock_taille::hasTailles($item->id_stock))

                                                    @foreach( \App\Models\Stock_taille::getTailles($item->id_stock) as $taille )
                                                        <tr>
                                                            <input type="hidden"
                                                                   name="id_article[{{ $item->id_stock }}][{{ $loop->index+1 }}]"
                                                                   value="{{ $item->id_article }}"/>

                                                            <input type="hidden"
                                                                   name="id_taille_article[{{ $item->id_stock }}][{{ $loop->index+1 }}]"
                                                                   value="{{ $taille->id_taille_article }}"/>


                                                            <td align="right">{{ \App\Models\Taille_article::getTaille($taille->id_taille_article) }}</td>
                                                            <td align="right">{{ $taille->quantite }}</td>
                                                            <td><input type="number" min="0" max="{{ $taille->quantite }}"
                                                                       placeholder="Quantite"
                                                                       width="5" class="form-control"
                                                                       name="quantiteIN[{{ $item->id_stock }}][{{ $loop->index+1 }}]"
                                                                       value="{{ old('quantiteIN.'.($item->id_stock).'.'.($loop->index+1).'') }}">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- /.Container --}}



                    @endforeach

                    <div class="row" align="center">
                        <input type="submit" value="Valider le transfert" formtarget="_blank"
                               class="btn btn-outline btn-success">
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
