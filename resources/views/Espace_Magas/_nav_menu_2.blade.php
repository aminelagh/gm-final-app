<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">

            <li>
                <a href="{{ Route('magas.home') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>

            <li>
                <a href="{{ Route('magas.promotions') }}"><i class="fa fa-dashboard fa-fw"></i> Promotions</a>
            </li>

            <li>
                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Gestion des magasins <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ Route('magas.magasin') }}">Magasin principal</a>
                    </li>
                    <li>
                        <a href="{{ Route('magas.magasins') }}">Autres magasins</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Gestion des ventes <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ Route('magas.addVente') }}">Nouvelle vente</a>
                    </li>
                    <li>
                        <a href="{{ Route('magas.ventes') }}">Ventes</a>
                    </li>
                    <li>
                        <a href="{{ Route('magas.clients') }}">Clients</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Gestion des articles <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ Route('magas.articles') }}">Articles</a>
                    </li>
                    <li>
                        <a href="{{ Route('magas.fournisseurs') }}">Fournisseurs</a>
                    </li>
                    <li>
                        <a href="{{ Route('magas.categories') }}">Categories</a>
                    </li>
                    <li>
                        <a href="{{ Route('magas.marques') }}">Marques</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Gestion des transactions <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ Route('magas.entrees') }}">Entrees de stock</a>
                    </li>
                    <li>
                        <a href="{{ Route('magas.sorties') }}">Sorties de stock</a>
                    </li>
                    <li>
                        <a href="{{ Route('magas.transfertINs') }}">Transfert IN</a>
                    </li>
                    <li>
                        <a href="{{ Route('magas.transfertOUTs') }}">Transfert OUT</a>
                    </li>
                    <li>
                        <a href="{{ Route('magas.ventes') }}">Ventes</a>
                    </li>

                </ul>
            </li>

        </ul>
    </div>
</div>