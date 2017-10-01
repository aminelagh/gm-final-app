<ul class="nav navbar-top-links navbar-right">

    {{-- Dropdown Alerts --}}
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-alerts">
            <li>
                <a href="#">
                    <div>
                        <span class="pull-right text-muted small">Vous n'avez aucune notification enregistrée</span>
                    </div>
                </a>
            </li>

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
