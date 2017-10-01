@extends('layouts.main_master')

@section('title') Nouveau magasin @endsection

@section('main_content')

    <h1 class="page-header">Ajouter un magasin</h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des stocks</li>
        <li class="breadcrumb-item active"><a
                    href="{{ Route('magas.magasins') }}"> Liste des
                magasins</a></li>
        <li class="breadcrumb-item active">Création d'un magasin</li>
    </ol>


    <form role="form" method="post" action="{{ Route('magas.submitAddMagasin') }}">
        {{ csrf_field() }}

        <div class="panel panel-default">

            <div class="panel-heading">
                Nouvelle categorie
            </div>
            <div class="panel-body">
                <div class="row">
                    {{-- Libelle --}}
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Libelle *</label>
                            <input type="text" class="form-control" placeholder="Libelle " name="libelle"
                                   value="{{ old('libelle') }}" required autofocus>
                        </div>
                    </div>

                    {{-- Ville --}}
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Ville</label>
                            <input type="text" class="form-control" placeholder="Ville " name="ville"
                                   value="{{ old('ville') }}">
                        </div>
                    </div>
                    {{-- Adresse --}}
                    <div class="col-lg-7">
                        <div class="form-group">
                            <label>Adresse</label>
                            <input type="text" class="form-control" placeholder="Adresse " name="adresse"
                                   value="{{ old('adresse') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Agent --}}
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Agent</label>
                            <input type="text" class="form-control" placeholder="Agent " name="agent"
                                   value="{{ old('agent') }}">
                        </div>
                    </div>

                    {{-- Agent --}}
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Email " name="email"
                                   value="{{ old('email') }}">
                        </div>
                    </div>

                    {{-- Telephone --}}
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Telephone</label>
                            <input type="text" class="form-control" placeholder="Telephone " name="telephone"
                                   value="{{ old('telephone') }}">
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