@extends('layouts.main_master')

@section('title') {{ $data->nom }} {{ $data->prenom }} @endsection

@section('main_content')
    <br>

    <form id="deleteForm" action="{{ route('admin.deleteUser',[$data->id]) }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="DELETE" form="deleteForm">

    </form>


    <div class="col-lg-2"></div>
    <form method="POST" action="{{ route('admin.submitUpdateUser') }}">
        {{ csrf_field() }}
        <input type="hidden" name="id_user" value="{{ $data->id }}">

        <div class="col-lg-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Modification du Profile
                </div>
                <div class="panel-body">

                    {{-- row 1 --}}
                    <div class="row">
                        {{-- role --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control" name="role_name">
                                    @foreach( $roles as $role )
                                        <option value="{{ $role->name }}"
                                                @if( $role->name == \App\Models\User::getRole($data->id) ) selected @endif > {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- magasin --}}
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Magasin <i
                                            class="glyphicon glyphicon-info-sign" {!! setPopOver("","Veuillez choisir un magasin si le role est \"vendeur\"") !!}></i></label>
                                <select class="form-control" name="id_magasin">
                                    @if( !$magasins->isEmpty() )
                                        <option value="0" @if( true ) selected @endif>Aucun</option>
                                        @foreach( $magasins as $magasin )
                                            <option value="{{ $magasin->id_magasin }}"
                                                    @if( $magasin->id_magasin == $data->id_magasin ) selected @endif > {{ $magasin->libelle }}
                                                <small>({{ $magasin->ville }})</small>
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>


                    </div>

                    {{-- row 2 --}}
                    <div class="row">
                        {{-- Email --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                       value="{{ $data->email }}">
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="text" name="password" class="form-control" placeholder="Password"
                                       onClick="this.select();"
                                       value="{{ old('password') }}">
                            </div>
                        </div>

                    </div>

                    {{-- row 3 --}}
                    <div class="row">

                        {{-- nom --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" class="form-control" placeholder="Nom" name="nom"
                                       value="{{ $data->nom }}">
                            </div>
                        </div>
                        {{-- prenom --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Prenom</label>
                                <input type="text" class="form-control" placeholder="Prenom" name="prenom"
                                       value="{{ $data->prenom }}">
                            </div>
                        </div>

                    </div>

                    {{-- row 4 --}}
                    <div class="row">

                        {{-- ville --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Ville</label>
                                <input type="text" class="form-control" placeholder="Ville" name="ville"
                                       value="{{ $data->ville }}">
                            </div>
                        </div>
                        {{-- telephone --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Telephone</label>
                                <input type="text" class="form-control" placeholder="Telephone" name="telephone"
                                       value="{{ $data->telephone }}">
                            </div>
                        </div>
                        {{-- last login --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Dernière connexion</label>
                                <input type="text" class="form-control" placeholder="Prenom" name="prenom"
                                       disabled=""
                                       value="{{ getDateHelper($data->last_login) }}">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="panel-footer" align="center">
                    <input type="submit" value="Valider" class="btn btn-primary">
                    <input type="reset" value="Réinitialiser" class="btn btn-outline btn-primary">
                    <button type="submit" class="btn btn-danger btn-outline" form="deleteForm">
                        Supprimer
                    </button>
                </div>

            </div>
        </div>
    </form>
    <div class="col-lg-2"></div>
@endsection

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection