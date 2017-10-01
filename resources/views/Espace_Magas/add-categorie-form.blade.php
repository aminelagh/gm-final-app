@extends('layouts.main_master')

@section('title') Nouvelle categorie @endsection

@section('main_content')

    <h3 class="page-header">Ajouter une categorie</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des Articles</li>
        <li class="breadcrumb-item active"><a
                    href="{{ Route('magas.categories') }}"> Liste des
                categories</a></li>
        <li class="breadcrumb-item active">Création d'une categorie</li>
    </ol>


    <form role="form" method="post" action="{{ Route('magas.submitAddCategorie') }}">
        {{ csrf_field() }}

        <div class="panel panel-default">

            <div class="panel-heading">
                Nouvelle categorie
            </div>
            <div class="panel-body">
                <div class="row">

                    {{-- Libelle --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Categorie *</label>
                            <input type="text" class="form-control" placeholder="Libelle " name="libelle"
                                   value="{{ old('libelle') }}" required autofocus>
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