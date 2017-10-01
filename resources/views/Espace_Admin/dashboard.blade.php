@extends('layouts.main_master')

@section('title') Espace Admin @endsection

@section('main_content')

    <h1 class="page-header">Espace administrateur</h1>

    @include('layouts.alerts')

    <div class="row">




        {{-- Affiche  --}}
        @if(\App\Models\Article::hasNonValideArticles())
            <div class="col-lg-2 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="glyphicon glyphicon-book fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ count(App\Models\Article::nonValideArticles()) }}</div>
                                <div>Articles non validés</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ Route('admin.articles_nv') }}">
                        <div class="panel-footer">
                            <span class="pull-left">Consulter</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
              </div>
@endif
                <div class="col-lg-2 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-gift fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{App\Models\Promotion::where('date_fin','>=',new Carbon\Carbon())->where('id_magasin',1)->count() }}</div>
                                    <div>Promotions</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ Route('admin.promotions') }}">
                            <div class="panel-footer">
                                <span class="pull-left">Afficher Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-arrow-down fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{App\Models\Transaction::where('id_type_transaction',1)->count() }}</div>
                                    <div>Entrées Stock</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ Route('admin.entrees') }}">
                            <div class="panel-footer">
                                <span class="pull-left">Afficher Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-arrow-up fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{App\Models\Transaction::where('id_type_transaction',2)->count() }}</div>
                                    <div>Sorties Stock</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ Route('admin.sorties') }}">
                            <div class="panel-footer">
                                <span class="pull-left">Afficher Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-arrow-down fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{App\Models\Transaction::where('id_type_transaction',3)->count() }}</div>
                                    <div>Transferts IN</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ Route('admin.transfertINs') }}">
                            <div class="panel-footer">
                                <span class="pull-left">Afficher Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-arrow-up fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{App\Models\Transaction::where('id_type_transaction',4)->count() }}</div>
                                    <div>Transferts OUT</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ Route('admin.transfertOUTs') }}">
                            <div class="panel-footer">
                                <span class="pull-left">Afficher Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        

    </div>

@endsection

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection


{{-- Affiche
        {{ Form::open(array('url' => 'foo/bar','method' => 'delete')) }}
        {{ Form::text('email', 'example@gmail.com',array('class' => 'form-control')) }}
        {{ Form::submit('Click Me!') }}
        {{ Form::close() }}

        <hr>

        <form method="POST" action="http://golfmaroc/foo/bar" accept-charset="UTF-8">
            <input name="_method" type="text" value="DELETE" readonly>
            <input name="_token" type="hidden" value="N9ztUoKYkJzq1RUuQ0ZYD7FpG72EwUc80bbktXWn">
            <input class="form-control" name="email" type="text" value="example@gmail.com">
            <input type="submit" value="Click Me!">
        </form>

         Affiche  --}}
