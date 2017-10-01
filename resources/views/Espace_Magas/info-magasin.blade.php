@extends('layouts.main_master')

@section('title'){{ $data->libelle }} @endsection

@section('main_content')

    <h3 class="page-header"><strong>{{ $data->libelle }}</strong></h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des magasins</li>
        <li class="breadcrumb-item "><a href="{{ route('magas.magasins') }}">Liste des magasins</a></li>
        <li class="breadcrumb-item active">{{ $data->libelle  }}</li>
    </ol>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

            <form method="POST" action="{{ route('magas.submitUpdateMagasin') }}">
                {{ csrf_field() }}

                <input type="hidden" name="id_magasin" value="{{ $data->id_magasin }}">

                <div class="panel panel-default">
                    <div class="panel-heading" align="center">
                        <h4><b>{{ $data->libelle }}</b></h4>
                    </div>
                    <div class="panel-body">

                        <table class="table table-hover" border="0" cellspacing="0" cellpadding="5">
                            <tr>
                                <td colspan="2">
                                    <center><a href="{{ Route('magas.stocks',['id_magasin'=> $data->id_magasin ]) }}"
                                               class="btn btn-success" {!! setPopOver("","Afficher le stock du magasin") !!}>Afficher le stock</a>
                                        <a href="{{ Route('magas.addStock',['p_id' => $data->id_magasin]) }}"
                                           class="btn btn-success" {!! setPopOver("","Creer le stock du magasin") !!}>Creer le stock</a></center>
                                </td>
                            </tr>
                            <tr>
                                <td>Magasin</td>
                                <th><input class="form-control" type="text" name="libelle" value="{{ $data->libelle }}" placeholder="Magasin">
                                </th>
                            </tr>
                            <tr>
                                <td>Ville</td>
                                <th><input class="form-control" type="text" name="ville" value="{{ $data->ville }}" placeholder="Ville">
                                </th>
                            </tr>
                            <tr>
                                <td>Adresse</td>
                                <th><input class="form-control" type="text" name="adresse" value="{{ $data->adresse }}" placeholder="Adresse">
                                </th>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td>Agent</td>
                                <th><input class="form-control" type="text" name="agent" value="{{ $data->agent }}" placeholder="Agent">
                                </th>
                            </tr>
                            <tr>
                                <td>Telephone</td>
                                <th><input class="form-control" type="text" name="telephone" value="{{ $data->telephone }}" placeholder="Telephone">
                                </th>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <th><input class="form-control" type="email" name="email" value="{{ $data->email }}" placeholder="Email">
                                </th>
                            </tr>
                            <tr>
                                <td>Date de creation</td>
                                <th>{{ getDateHelper($data->created_at) }} a {{ getTimeHelper($data->created_at) }}   </th>
                            </tr>
                            <tr>
                                <td>Date de derniere modification</td>
                                <th>{{ getDateHelper($data->updated_at) }} a {{ getTimeHelper($data->updated_at) }}     </th>
                            </tr>
                        </table>

                    </div>
                    <div class="panel-footer" align="center">
                        <input type="submit" value="Valider"
                               class="btn btn-primary" {!! setPopOver("","Valider les modification") !!}>
                        <input type="reset" value="Réinitialiser"
                               class="btn btn-outline btn-primary" {!! setPopOver("","Valider les modification") !!}>
                    </div>


                </div>

            </form>
        </div>
        <div class="col-lg-1"></div>
    </div>



@endsection

@section('scripts')

@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection
