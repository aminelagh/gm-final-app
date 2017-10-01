@extends('layouts.main_master')

@section('title') Promotion: {{ \App\Models\Article::getDesignation($data->id_article) }} @endsection

@section('main_content')

    <h3 class="page-header">Modifier la Promotion sur l'article : {{ \App\Models\Article::getDesignation($data->id_article) }} </h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des promotions</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.promotions') }}">Liste des promotions</a></li>
        <li class="breadcrumb-item active">{{ \App\Models\Article::getDesignation($data->id_article) }}</li>
    </ol>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

            <form method="POST" action="{{ Route('admin.submitUpdatePromotion') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id_promotion" value="{{ $data->id_promotion }}">

                <div class="panel panel-default">
                    <div class="panel-heading" align="center">
                        <h4><b>{{ \App\Models\Article::getDesignation($data->id_article) }}</b></h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover">
                            <tr>
                                <td>Magasin</td>
                                <th>
                                    <select class="form-control" name="id_magasin">
                                        @if( !$magasins->isEmpty() )
                                            @foreach( $magasins as $item )
                                                <option value="{{ $item->id_magasin }}"
                                                        @if( $item->id_magasin == $data->id_magasin ) selected @endif > {{ \App\Models\Magasin::getLibelle($item->id_magasin) }}
                                                    <small>({{ \App\Models\Magasin::getVille($item->id_magasin) }})
                                                    </small>
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </th>
                            </tr>
                            <tr>
                                <td>Taux de la promotion</td>
                                <th>
                                    <div class="input-group">
                                        <input type="number" pattern=".##" class="form-control"
                                               placeholder="Taux" name="taux" value="{{ $data->taux }}"
                                               aria-describedby="basic-addon1">
                                        <span class="input-group-addon" id="basic-addon1">%</span>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td>Date debut</td>
                                <th>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input class="form-control" id="date" name="date_debut" placeholder="jj-mm-aaaa"
                                               value="{{ (new DateTime($data->date_debut))->format('d-m-Y') }}"
                                               type="date">
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td>Date fin</td>
                                <th>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input class="form-control" id="date" name="date_fin" placeholder="jj-mm-aaaa"
                                               value="{{ (new DateTime($data->date_fin))->format('d-m-Y') }}"
                                               type="date">
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td>Etat</td>
                                <th>
                                    <input type="checkbox" name="active" value="1" {{ $data->active==true ? 'checked' : '' }}>


                                </th>
                            </tr>

                            <tr>
                                <td align="center" colspan="2"><b>Detail article</b></td>
                            </tr>

                            <tr>
                                <td>Code</td>
                                <th colspan="2">{{ \App\Models\Article::getCode($data->id_article) }}</th>
                            </tr>
                            <tr>
                                <td>Reference</td>
                                <th colspan="2">
                                    {{ \App\Models\Article::getRef($data->id_article) }}
                                    {{ \App\Models\Article::getAlias($data->id_article)!=null ? ' - '.\App\Models\Article::getAlias($data->id_article):' ' }}
                                </th>
                            </tr>
                            <tr>
                                <td>Marque</td>
                                <th colspan="2">{{ \App\Models\Article::getMarque($data->id_article) }}</th>
                            </tr>
                            <tr>
                                <td>Categorie</td>
                                <th colspan="2">{{ \App\Models\Article::getCategorie($data->id_article) }}</th>
                            </tr>
                            <tr>
                                <td>Fournisseur</td>
                                <th colspan="2">{{ \App\Models\Article::getFournisseur($data->id_article) }}</th>
                            </tr>
                            <tr>
                                <td>Couleur</td>
                                <th colspan="2">{{ \App\Models\Article::getCouleur($data->id_article) }}</th>
                            </tr>
                            <tr>
                                <td>Sexe</td>
                                <th colspan="2">{{ \App\Models\Article::getSexe($data->id_article) }}</th>
                            </tr>
                            <tr>
                                <td>Prix d'achat</td>
                                <th>{{ \App\Models\Article::getPrixAchatHT($data->id_article) }}
                                    Dhs HT
                                </th>
                                <th>
                                    {{ \App\Models\Article::getPrixAchatTTC($data->id_article) }}
                                    Dhs TTC
                                </th>
                            </tr>
                            <tr>
                                <td>Prix de vente</td>
                                <th>{{ \App\Models\Article::getPrixHT($data->id_article) }}
                                    Dhs HT
                                </th>
                                <th>
                                    {{ \App\Models\Article::getPrixTTC($data->id_article) }}
                                    Dhs TTC
                                </th>
                            </tr>
                            <tr>
                                <td>Prix de gros</td>
                                <th>{{ \App\Models\Article::getPrixGrosHT($data->id_article) }}
                                    Dhs HT
                                </th>
                                <th>
                                    {{ \App\Models\Article::getPrixGrosTTC($data->id_article) }}
                                    Dhs TTC
                                </th>
                            </tr>
                            <tr>
                                <td>Date de creation</td>
                                <th>{{ getDateHelper($data->created_at) }}
                                    a {{ getTimeHelper($data->created_at) }}   </th>
                            </tr>
                            <tr>
                                <td>Date de derniere modification</td>
                                <th>{{ getDateHelper($data->updated_at) }}
                                    a {{ getTimeHelper($data->updated_at) }}     </th>
                            </tr>

                            @if(\App\Models\Article::getImage($data->id_article)!=null)
                                <tr>
                                    <td colspan="2" align="middle">
                                        <img src="{{ \App\Models\Article::getImage($data->id_article) }}" width="200"
                                             hight="200">
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="panel-footer" align="center">
                        <input type="submit" value="Valider"
                               class="btn btn-primary" {!! setPopOver("","Valider les modification") !!}>
                        <input type="reset" value="Réinitialiser"
                               class="btn btn-outline btn-primary" {!! setPopOver("","Valider les modification") !!}>
                    </div>
                </div>

            </form>
        </div>
        <div class="col-lg-1"></div>
    </div>


@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        (function ($) {
            $.fn.datepicker.dates['fr'] = {
                days: ["dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"],
                daysShort: ["dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam."],
                daysMin: ["di", "lu", "ma", "me", "j", "v", "s"],
                months: ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"],
                monthsShort: ["janv.", "févr.", "mars", "avril", "mai", "juin", "juil.", "août", "sept.", "oct.", "nov.", "déc."],
                today: "Aujourd'hui",
                monthsTitle: "Mois",
                clear: "Effacer",
                weekStart: 1,
                format: "dd/mm/yyyy"
            };
        }(jQuery));

        $(document).ready(function () {
            var date_input = $('input[id="date"]');
            //var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
            date_input.datepicker({
                format: 'dd-mm-yyyy',
                //container: container,
                todayHighlight: true,
                autoclose: true,
                language: 'fr',
            });
        });
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.css') }}"/>
@endsection

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection
