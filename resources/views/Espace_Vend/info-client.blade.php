@extends('layouts.main_master')

@section('title') Client: {{ $data->nom.' '.$data->prenom }} @endsection

@section('main_content')

    <h3 class="page-header">Client</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des ventes</li>
        <li class="breadcrumb-item"><a href="{{ route('magas.clients') }}">Liste
                des clients</a></li>
        <li class="breadcrumb-item active">{{ $data->nom.' '.$data->prenom }}</li>
    </ol>


    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

            <form method="POST" action="{{ route('magas.submitUpdateClient') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id_client" value="{{ $data->id_client }}">


                <div class="panel panel-default">
                    <div class="panel-heading" align="center">
                        <h4><b>{{ $data->nom.' '.$data->prenom }}</b></h4>
                    </div>
                    <div class="panel-body">

                        <table class="table table-hover" border="0" cellspacing="0" cellpadding="5">

                            <tr>
                                <td>Nom</td>
                                <th><input class="form-control" type="text" name="nom" value="{{ $data->nom }}" required
                                           autofocus>
                                </th>
                            </tr>
                            <tr>
                                <td>Prenom</td>
                                <th><input class="form-control" type="text" name="prenom" value="{{ $data->prenom }}">
                                </th>
                            </tr>
                            <tr>
                                <td>Age</td>
                                <th><input class="form-control" type="number" min="0" name="age"
                                           value="{{ $data->age }}">
                                </th>
                            </tr>
                            <tr>
                                <td>Ville</td>
                                <th><input class="form-control" type="text" name="ville" value="{{ $data->ville }}">
                                </th>
                            </tr>
                            <tr>
                                <td>Sexe</td>
                                <td>
                                    <select class="form-control" name="sexe">
                                        <option value="Homme" {{ $data->sexe == 'Homme'? 'selected' : '' }}>Homme
                                        </option>
                                        <option value="Femme" {{ $data->sexe == 'Femme'? 'selected' : '' }}>Femme
                                        </option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Date de creation</td>
                                <th>{{ getDateHelper($data->created_at) }}
                                    a {{ getTimeHelper($data->created_at) }}   </th>
                            </tr>
                            <tr>
                                <td>Date de derniere modification</td>
                                <th>{{ getDateHelper($data->updated_at) }}
                                    a {{ getTimeHelper($data->updated_at) }}     </th>
                            </tr>
                            <tr>
                                <td>
                                    <div class="account-section-setting">
                                        <label>
                                            <span class="yt-uix-form-input-checkbox-container  checked">
                                                <input type="checkbox" class="yt-uix-form-input-checkbox" name="annotations_on_default" checked="checked">
                                                <span class="yt-uix-form-input-checkbox-element"></span></span>
                                            Afficher les annotations et les notifications dans les vidéos
                                        </label>
                                        <span class="yt-uix-clickcard">
                                            <span class="yt-uix-clickcard-target" data-position="topright">
                                                <span class="yt-help-icon yt-sprite"></span>
                                            </span>
                                            <div class="yt-uix-clickcard-content">
                                                <p class="yt">Autorise l&#39;affichage des messages et des zones mis en
                                                    surbrillance sur les vidéos. Cette option n&#39;a aucune incidence
                                                    sur les annonces qui peuvent être diffusées sur les vidéos.</p>
                                            </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel-footer" align="center">
                        <input type="submit" value="Valider"
                               class="btn btn-primary" {!! setPopOver("","Valider les modification") !!}>
                        <input type="reset" value="Réinitialiser"
                               class="btn btn-outline btn-primary">
                    </div>
                </div>

            </form>
        </div>
        <div class="col-lg-1"></div>
    </div>

@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection