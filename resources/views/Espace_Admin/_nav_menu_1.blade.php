<ul class="nav navbar-top-links navbar-right">

    {{-- Dropdown Alerts --}}
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-alerts">
            @if(\App\Models\Article::hasNonValideArticles())
                <li>
                    <a href="{{ Route('admin.articles_nv') }}">
                        <div>
                            <i class="fa fa-comment fa-fw"></i> vous avez des articles a valider
                            <span class="pull-right text-muted small">{{ count(\App\Models\Article::nonValideArticles()) }}
                                article(s)</span>
                        </div>
                    </a>
                </li>
            @endif

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
            <li><a href="{{ route('admin.profile') }}"><i class="fa fa-user fa-fw"></i> Profil</a>
            </li>
            <li class="divider"></li>
            <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Se deconnecter</a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    {{-- Dropdown User --}}

</ul>
