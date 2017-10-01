@extends('layouts.main_master')

@section('title') Espace Magasinier @endsection

@section('main_content')
    <h1 class="page-header">Espace magasinier</h1>

    <div class="row">
        <div class="col-lg-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <img src="img/logo_gm2.png" width="200px" height="80px">
                        </div>
                        <div class="col-xs-9 text-right">
                        </div>
                    </div>
                </div>
                <a href="{{ Route('magas.stocks') }}">
                    <div class="panel-footer">
                        <span class="pull-left">Afficher Le Stock du magasin principal</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-gift fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{App\Models\Promotion::where('date_fin','>=',new Carbon\Carbon())->where('id_magasin',1)->count() }}</div>
                            <div>Promos disponibles</div>
                        </div>
                    </div>
                </div>
                <a href="{{ Route('magas.promotions') }}">
                    <div class="panel-footer">
                        <span class="pull-left">Afficher Promotions</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-arrow-down fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{App\Models\Transaction::where('id_magasin',1)->where('id_type_transaction',1)->count() }}</div>
                            <div> Entrées de Stock</div>
                        </div>
                    </div>
                </div>
                <a href="{{ Route('magas.addStockIN') }}">
                    <div class="panel-footer">
                        <span class="pull-left">Faire Entree de stock F</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-arrow-up fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{App\Models\Transaction::where('id_magasin',1)->where('id_type_transaction',2)->count() }}</div>
                            <div> Sorties de Stock</div>
                        </div>
                    </div>
                </div>
                <a href="{{ Route('magas.addStockOUT') }}">
                    <div class="panel-footer">
                        <span class="pull-left">Faire Sortie de Stock F</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        @foreach($magasins as $magasin)
            <div class="col-lg-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-2">
                                <i class="fa fa-book fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="medium">{{ $magasin->libelle }}</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ Route('magas.stocks',[$magasin->id_magasin]) }}">
                        <div class="panel-footer">
                            <span class="pull-left">Afficher le stock des autres magasins</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach


    </div>
@endsection

@section('scripts')
    <script>

    </script>
@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection
