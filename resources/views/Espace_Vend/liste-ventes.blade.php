@extends('layouts.main_master')

@section('title') Liste ventes  @endsection

@section('main_content')

    <h3 class="page-header">Ventes du magasin
        <strong></strong></h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('vend.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des ventes</li>
        <li class="breadcrumb-item active">Liste des ventes</li>
    </ol>



    <div class="row">
        @if( !$data->isEmpty() )
            <div class="breadcrumb">
                Afficher/Masquer:
                <a class="toggle-vis" data-column="0">Date de vente</a> -
                <a class="toggle-vis" data-column="1">Mode de paiement</a> -
                <!-- <a class="toggle-vis" data-column="3">Promotion</a> -->

            </div>
        @endif
    </div>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>

                        <th  >Date de vente</th>
                        <th  >Mode de paiement</th>
                        <th  >Promotion</th>

                        <th  >Detais</th>

                    </tr>

                    </thead>
                    <tfoot>
                    <tr>

                      <th  >Date de vente</th>
                      <th  >Mode de paiement</th>
                      <th  >Promotion</th>

                      <th  >Detais</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach( $data as $item )
                        <tr >


                            <td>
                                {{ getDateHelper(\App\Models\Vente::getDate($item->id_vente)) }}</td>
                            <td>{{ \App\Models\Vente::getMode($item->id_paiement) }}</td>

                            <td align="center">
                                @if($item->id_promotion == null)
                                    <div id="circle" style="background: darkred;" {!! setPopOver("Vente Non promotionnelle",\App\Models\Vente_article::where(['id_vente'=>$item->id_vente])->get()->count()." article(s)") !!}></div>
                                @else
                                    <div id="circle"
                                         style="background: green;" {!! setPopOver("Vente Sous Promotion",\App\Models\Vente_article::where(['id_vente'=>$item->id_vente])->get()->count()." article(s)") !!}></div>
                                @endif
                            </td>
                            <td align="center">
                                <a href="{{ Route('vend.vente',[ 'p_id' => $item->id_vente ]) }}"><i
                                            class="glyphicon glyphicon-shopping-cart"
                                            aria-hidden="false"></i></a>
                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <br/>

    <hr/>
    <br/>
@endsection

@section('scripts')
    @if(!$data->isEmpty())
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function () {
                var table = $('#myTable').DataTable({
                    "lengthMenu": [[10, 20, 30, 50, -1], [10, 20, 30, 50, "Tout"]],
                    "searching": true,
                    "paging": true,
                    //"autoWidth": true,
                    "info": false,
                    stateSave: false,
                    "columnDefs": [
                        {"visible": true, "targets": -1},

                        {"searchable": false, "orderable": false, "targets": 0},
                        {"width": "30%", "targets": 1, "type": "num", "visible": true, "searchable": false}, //#
                        {"width": "30%", "targets": 2, "type": "string", "visible": true},  //ref
                        //{"width": "03%", "targets": 2, "type": "string", "visible": true},  //code

                        //{"width": "08%", "targets": 3, "type": "string", "visible": true},    //desi
                    //    {"width": "08%", "targets": 4, "type": "string", "visible": true},     //Marque


                        //{"width": "04%", "targets": 3, "type": "num-fmt", "visible": true, "searchable": false}
                    ],
                    "select": {
                        items: 'column'
                    }
                });

                // table.on('order.dt search.dt', function () {
                //     table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                //         cell.innerHTML = i + 1;
                //     });
                // }).draw();

                // Setup - add a text input to each footer cell
                $('#myTable tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Date de vente" || title == "Mode de paiement") {
                        $(this).html('<input type="text" size="20" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }

                    else if (title == "Promotion") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }


                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                });

                //footer input: hide text
                $('a.toggle-vis').on('click', function (e) {
                    e.preventDefault();
                    var column = table.column($(this).attr('data-column'));
                    column.visible(!column.visible());
                });

                //footer search
                table.columns().every(function () {
                    var that = this;
                    $('input', this.footer()).on('keyup change', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
            });
        </script>
    @endif
@endsection

@section('menu_1')@include('Espace_Vend._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Vend._nav_menu_2')@endsection

@section('styles')
    <style>
        #circle {
            width: 15px;
            height: 15px;
            -webkit-border-radius: 25px;
            -moz-border-radius: 25px;
            border-radius: 25px;
        }

        #myTable {
            width: 100%;
            border: 0px solid #D9D5BE;
            border-collapse: collapse;
            margin: 0px;
            background: white;
            font-size: 1em;
        }

        #myTable td {
            padding: 5px;
        }


    </style>
@endsection
