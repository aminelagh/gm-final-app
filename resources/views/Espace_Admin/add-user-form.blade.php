@extends('layouts.main_master')

@section('title') Nouvel utilisateur @endsection

@section('main_content')
    <br>

    @include('layouts.alerts')

    <div class="col-lg-2"></div>
    <form method="POST" action="{{ route('admin.submitAddUser') }}">
        {{ csrf_field() }}

        <div class="col-lg-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Nouvel utilisateur
                </div>
                <div class="panel-body">

                    {{-- row 1 --}}
                    <div class="row">

                        {{-- role --}}
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label>Role *</label>
                                <select class="form-control" name="role_name">
                                    @foreach( $roles as $item )
                                        <option value="{{ $item->name }}"
                                                @if( $item->name == old('role_name') ) selected @endif > {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- magasin --}}
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label>Magasin</label>
                                <select class="form-control" name="id_magasin">
                                    <option value="0"><i>Aucun</i></option>
                                    @if( !$magasins->isEmpty() )
                                        @foreach( $magasins as $magasin )
                                            <option value="{{ $magasin->id_magasin }}"
                                                    @if( $magasin->id_magasin == old('id_magasin') ) selected @endif > {{ $magasin->libelle }}
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
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email *</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" required
                                       value="{{ old('email') }}">
                            </div>
                        </div>
                        {{-- password --}}
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password *</label>
                                <input type="text" name="password" class="form-control" placeholder="Password" required
                                       value="{{ old('password') }}">
                            </div>
                        </div>
                    </div>

                    {{-- row 3 --}}
                    <div class="row">

                        {{-- nom --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom *</label>
                                <input type="text" class="form-control" placeholder="Nom" name="nom" required
                                       value="{{ old('nom') }}">
                            </div>
                        </div>
                        {{-- prenom --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Prenom</label>
                                <input type="text" class="form-control" placeholder="Prenom" name="prenom"
                                       value="{{ old('prenom') }}">
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
                                       value="{{ old('ville') }}">
                            </div>
                        </div>
                        {{-- telephone --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Telephone</label>
                                <input type="text" class="form-control" placeholder="Telephone" name="telephone"
                                       value="{{ old('telephone') }}">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="panel-footer" align="center">
                    <input type="submit" value="Valider" class="btn btn-outline btn-primary">
                    <input type="reset" value="effacer" class="btn btn-outline btn-default">
                </div>
            </div>
        </div>
    </form>
    <div class="col-lg-2"></div>
@endsection

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection