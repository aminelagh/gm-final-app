<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">

            <li>
                <a href="{{route('admin.home')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="{{ route('admin.users' ) }}"><i class="fa fa-user fa-fw"></i> Utilisateurs</a>
            </li>
            <li>
                <a href="{{ route('admin.magasins' ) }}"><i class="fa fa-list fa-fw"></i> Magasins</a>
            </li>
            <li>
                <a href="{{ route('admin.articles') }}"><i class="fa fa-list fa-fw"></i> Articles</a>
            </li>
            <li>
                <a href="{{ route('admin.promotions') }}"><i class="fa fa-shopping-cart fa-fw"></i>Promotions</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Gestion des transactions <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('admin.entrees') }}">Entrées de stock
                            <i class="glyphicon glyphicon-arrow-down"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.sorties') }}">Sorties de stock<i
                                    class="glyphicon glyphicon-arrow-up"></i></a>
                    </li>

                    <li>
                        <a href="{{ route('admin.transfertINs') }}">Transferts Stock IN
                            <i class="glyphicon glyphicon-collapse-up"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.transfertOUTs') }}">Transferts Stock Out <i
                                    class="glyphicon glyphicon-collapse-down"></i></a>
                    </li>
                    <li>
                        <a href="{{ route('admin.ventes') }}">Ventes <i class="glyphicon glyphicon-shopping-cart"></i></a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
