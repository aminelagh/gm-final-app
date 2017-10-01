@extends('layouts.main_master')

@section('title') Nouveau client @endsection

@section('main_content')

    <h3 class="page-header">Ajouter un client</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des ventes</li>
        <li class="breadcrumb-item"><a href="{{ Route('magas.clients') }}">
                Liste des clients</a></li>
        <li class="breadcrumb-item active">Création d'un client</li>
    </ol>


    <form role="form" method="post"
          action="{{ Route('magas.submitAddClient') }}">
        {{ csrf_field() }}

        <div class="panel panel-default">

            <div class="panel-heading">
                Nouveau client
            </div>
            <div class="panel-body">
                <div class="row">

                    {{-- Libelle --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nom *</label>
                            <input type="text" class="form-control" placeholder="Nom" name="nom"
                                   value="{{ old('nom') }}" required autofocus>
                        </div>
                    </div>

                    {{-- Libelle --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Prenom</label>
                            <input type="text" class="form-control" placeholder="Prenom " name="prenom"
                                   value="{{ old('prenom') }}">
                        </div>
                    </div>

                </div>
                <div class="row">

                    {{-- Libelle --}}
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Ville</label>
                            <input type="text" class="form-control" placeholder="Ville " name="ville"
                                   value="{{ old('ville') }}">
                        </div>
                    </div>

                    {{-- Libelle --}}
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Age *</label>
                            <input type="number" class="form-control" placeholder="Age " name="age"
                                   value="{{ old('age') }}">
                        </div>
                    </div>

                    {{-- Libelle --}}
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Sexe</label>
                            <select class="form-control" name="sexe">
                                <option value="Homme" {{ old('sexe') == 'Homme'? 'selected' : '' }}>Homme</option>
                                <option value="Femme" {{ old('sexe') == 'Femme'? 'selected' : '' }}>Femme</option>
                            </select>
                        </div>
                    </div>


                </div>
            </div>
            <div class="panel-footer" align="center">
                {{-- Submit & Reset --}}
                <button type="submit" name="submit" value="valider" class="btn btn-default">Valider</button>
                <button type="reset" class="btn btn-default">Effacer</button>

            </div>

        </div>
    </form>

@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection