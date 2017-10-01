@extends('layouts.main_master')

@section('title') Profile Magasinier @endsection

@section('main_content')
    <br>

    @include('layouts.alerts')

    <div class="col-lg-2"></div>
    <form method="POST" action="{{ route('magas.submitUpdateProfile') }}">
        {{ csrf_field() }}
        <input type="hidden" name="id_user" value="{{ $data->id }}">

        <div class="col-lg-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Modification du Profile
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Role</label>
                                <input type="text" class="form-control" disabled placeholder="Company"
                                       value="Magasinier">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $data->email }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" class="form-control" placeholder="Nom" name="nom" value="{{ $data->nom }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Prenom</label>
                                <input type="text" class="form-control" placeholder="Prenom" name="prenom"
                                       value="{{ $data->prenom }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Ville</label>
                                <input type="text" class="form-control" placeholder="Ville" name="ville" value="{{ $data->ville }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Telephone</label>
                                <input type="text" class="form-control" placeholder="Telephone" name="telephone"
                                       value="{{ $data->telephone }}">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="panel-footer" align="center">
                    <input type="submit" value="Valider" class="btn btn-primary" {!! setPopOver("","Valider les modification") !!}>
                    <input type="reset" value="Réinitialiser" class="btn btn-outline btn-primary" {!! setPopOver("","Valider les modification") !!}>
                    <a href="{{ route('magas.updatePassword') }}"
                       onclick="return confirm('Êtes-vous sure de vouloir modifier votre mot de passe: {{ $data->nom }} {{ $data->prenom }} ?')"
                       type="button" class="btn btn-outline btn-default">Modifier le mot de passe</a>
                </div>
            </div>
        </div>
    </form>
    <div class="col-lg-2"></div>
@endsection

@section('scripts')


@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection
