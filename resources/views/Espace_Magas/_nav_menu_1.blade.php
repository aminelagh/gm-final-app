<ul class="nav navbar-top-links navbar-right">

    {{-- Dropdown Alerts --}}
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-alerts">
            @if (\App\Models\Stock::getBadArticles(1)->count() > 0)
                <li>
                    <a href="{{ Route('magas.stocks') }}">
                        <div>
                            <i class="fa fa-upload fa-fw"></i> Stock du magasin principal demande votre attention
                            <span class="pull-right text-muted small">( {{ count(\App\Models\Stock::getBadArticles(1)) }} article(s) )</span>
                        </div>
                    </a>
                </li>
            @endif

            @foreach(\App\Models\Magasin::where('id_magasin','!=',1)->get() as $magasin)
                @if (\App\Models\Stock::getBadArticles($magasin->id_magasin)->count() > 0)
                    <li>
                        <a href="{{ Route('magas.stocks',[$magasin->id_magasin]) }}">
                            <div>
                                <i class="fa fa-upload fa-fw"></i> Stock du magasin <b>{{ $magasin->libelle }}</b> demande votre attention
                                <span class="pull-right text-muted small">( {{ count(\App\Models\Stock::getBadArticles($magasin->id_magasin)) }} article(s) )</span>
                            </div>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </li>
    {{-- /.Dropdown Alerts --}}

    {{-- Dropdown User --}}
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i> {{ Session::get('nom') }} {{ Session::get('prenom') }} <i
                    class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="{{ route('magas.profile') }}"><i class="fa fa-user fa-fw"></i> Profil</a>
            </li>
            <li class="divider"></li>
            <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Se deconnecter</a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    {{-- Dropdown User --}}

</ul>
