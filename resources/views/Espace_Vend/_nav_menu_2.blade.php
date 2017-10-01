<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">

            <li>
                <a href="{{ Route('vend.home') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>



            <li>
                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Gestion des ventes <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                  <li>
                      <a href="{{ Route('vend.main_stocks') }}"> Stock du magasin</a>
                  </li>
                    <li>
                        <a href="{{ Route('vend.addVenteSimple') }}">Vente simple</a>
                    </li>
                    <li>
                        <a href="{{ Route('vend.addVenteGros') }}">Vente de gros</a>
                    </li>
                    <li>
                        <a href="{{ Route('vend.ventes') }}"> Liste de Ventes</a>
                    </li>

                </ul>
            </li>
            <li>
                <a href="{{ Route('vend.promotions') }}"><i class="fa fa-gift fa-fw"></i> Promotions</a>
            </li>





        </ul>
    </div>
</div>
