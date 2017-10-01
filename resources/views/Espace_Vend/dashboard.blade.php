@extends('layouts.main_master')

@section('title') Espace Vendeur @endsection

@section('main_content')
    <h1 class="page-header">Espace Vendeur</h1>

    <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-book fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{App\Models\Stock::where('id_magasin',Session::get('id_magasin'))->count() }}</div>
                                        <div>Articles en Stock</div>

                                    </div>
                                </div>
                            </div>
                            <a href="{{ Route('vend.stocks') }}">
                                <div class="panel-footer">
                                    <span class="pull-left">Afficher Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-gift fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{App\Models\Promotion::where('date_fin','>=',new Carbon\Carbon())->where('id_magasin',Session::get('id_magasin'))->count() }}</div>
                                        <div>Promos disponibles</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ Route('vend.promotions') }}">
                                <div class="panel-footer">
                                    <span class="pull-left">Afficher Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{App\Models\Vente::where('id_magasin',Session::get('id_magasin'))->count() }}</div>
                                        <div>Ventes du magasin</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ Route('vend.ventes') }}">
                                <div class="panel-footer">
                                    <span class="pull-left">Afficher Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    </div>







@endsection

@section('scripts')
    <script>

    </script>
@endsection

@section('menu_1')@include('Espace_Vend._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Vend._nav_menu_2')@endsection
