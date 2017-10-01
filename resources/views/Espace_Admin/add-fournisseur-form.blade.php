@extends('layouts.main_master')

@section('title') Nouveau fournisseur @endsection

@section('main_content')

    <h1 class="page-header">Ajouter un fournisseur</h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des Articles</li>
        <li class="breadcrumb-item active"><a
                    href="{{ Route('magas.fournisseurs') }}"> Liste des
                fournisseurs</a></li>
        <li class="breadcrumb-item active">Création d'un fournisseur</li>
    </ol>


    <form role="form" method="post" action="{{ Route('magas.submitAddFournisseur') }}">
        {{ csrf_field() }}

        <div class="panel panel-default">

            <div class="panel-heading">
                Nouvelle categorie
            </div>
            <div class="panel-body">
                <div class="row">

                    {{-- Code --}}
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Code *</label>
                            <input type="text" class="form-control" placeholder="Code " name="code"
                                   value="{{ old('code') }}" required autofocus>
                        </div>
                    </div>

                    {{-- Libelle --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Fournisseur *</label>
                            <input type="text" class="form-control" placeholder="Libelle " name="libelle"
                                   value="{{ old('libelle') }}" required>
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