@extends('layouts.main_master')

@section('title') Nouvel agent @endsection

@section('main_content')

    <h3 class="page-header">Ajouter un agent</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des Articles</li>
        <li class="breadcrumb-item"><a
                    href="{{ Route('magas.fournisseurs') }}"> Liste des
                fournisseurs</a></li>
        <li class="breadcrumb-item"><a
                    href="{{ Route('magas.fournisseur',['p_id'=>$fournisseur->id_fournisseur]) }}">{{ $fournisseur->libelle }}</a></li>
        <li class="breadcrumb-item active">Création d'un agent</li>
    </ol>

    <form role="form" method="post" action="{{ Route('magas.submitAddAgent') }}">
        {{ csrf_field() }}

        <input type="hidden" name="id_fournisseur" value="{{ $fournisseur->id_fournisseur }}">

        <div class="panel panel-default">

            <div class="panel-heading">
                Nouvel agent
            </div>
            <div class="panel-body">
                <div class="row">
                    {{-- Fournisseur --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Fournisseur</label>
                            <select class="form-control" name="id_fournisseur" disabled>
                                <option value="{{ $fournisseur->id_fournisseur }}">{{ $fournisseur->libelle }}</option>
                            </select>

                        </div>
                    </div>

                    {{-- Role --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Role *</label>
                            <input type="text" class="form-control" name="role" placeholder="Role"
                                   value="{{ old('role') }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Nom --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nom *</label>
                            <input type="text" class="form-control" name="nom" placeholder="Nom"
                                   value="{{ old('nom') }}" required>
                        </div>
                    </div>

                    {{-- Prenom --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Prenom</label>
                            <input type="text" class="form-control" name="prenom" placeholder="Prenom"
                                   value="{{ old('prenom') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Email --}}
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Email"
                                   value="{{ old('email') }}">
                        </div>
                    </div>

                    {{-- Telephone --}}
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Telephone</label>
                            <input type="text" class="form-control" name="telephone" placeholder="Telephone"
                                   value="{{ old('telephone') }}">
                        </div>
                    </div>

                    {{-- Ville --}}
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Ville</label>
                            <input type="text" class="form-control" name="ville" placeholder="Ville"
                                   value="{{ old('ville') }}">
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