@extends('layouts.main_master')

@section('title')   Profil de {{ $data->nom }} {{ $data->prenom }} @endsection

@section('main_content')
    <br>

    @include('layouts.alerts')

    <div class="col-lg-2"></div>
    <form method="POST" action="{{ route('admin.submitUpdateProfile') }}">
        {{ csrf_field() }}
        <input type="hidden" name="id_user" value="{{ $data->id }}">

        <div class="col-lg-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Profil de {{ $data->nom }} {{ $data->prenom }}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4><label>Role  :</label>
                                Vendeur
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4><label for="exampleInputEmail1">Email address  :</label>
                                {{ $data->email }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4><label>Nom  :</label>
                                {{ $data->nom }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <h4>  <label>Prenom  :</label>

                                      {{ $data->prenom }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <h4>  <label>Ville  :</label>
                              {{ $data->ville }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <h4>  <label>Telephone  : </label>
                              {{ $data->telephone }}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="panel-footer" align="center">
                    <a href="{{ route('vend.home') }}"

                       type="button" class="btn btn-primary">Retour Accueil</a>
                </div>
            </div>
        </div>
    </form>
    <div class="col-lg-2"></div>
@endsection

@section('scripts')


@endsection

@section('menu_1')@include('Espace_Vend._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Vend._nav_menu_2')@endsection
