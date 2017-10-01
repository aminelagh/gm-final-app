@extends('layouts.main_master')

@section('title') Modifier Magasin :  {{ $data->libelle }}@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Modifier un Magasin</h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item ">Gestion des magasins</li>
                    <li class="breadcrumb-item"><a href="{{ route('magas.lister',['p_table' => 'magasins' ]) }}">Liste
                            des magasins</a></li>
                    <li class="breadcrumb-item active">{{ $data->libelle }}</li>
                </ol>

                @include('layouts.alerts')

                {{-- *************** formulaire ***************** --}}
                <form role="form" method="post"
                      action="{{ Route('magas.submitUpdate',['p_table' => 'magasins']) }}">
                    {{ csrf_field() }}

                    <input type="hidden" class="form-control" name="id_magasin" value="{{ $data->id_magasin }}">


                    <!-- Row 1 -->
                    <div class="row">

                        <div class="col-lg-8">
                            {{-- Libelle --}}
                            <div class="form-group">
                                <label>Nom du magasin</label>
                                <input type="text" class="form-control" placeholder="Nom du magasin" name="libelle"
                                       value="{{ $data->libelle }}" required autofocus>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            {{-- Ville --}}
                            <div class="form-group">
                                <label>Ville</label>
                                <input type="text" class="form-control" placeholder="Ville" name="ville"
                                       value="{{ $data->ville }}">
                            </div>
                        </div>

                    </div>
                    <!-- end row 1 -->

                    <!-- Row 2 -->
                    <div class="row">

                        <div class="col-lg-4">
                            {{-- Agent --}}
                            <div class="form-group">
                                <label>Nom du representant</label>
                                <input type="text" class="form-control" placeholder="Agent" name="agent"
                                       value="{{ $data->agent }}">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            {{-- Telephone --}}
                            <div class="form-group">
                                <label>Telephone</label>
                                <input type="text" class="form-control" placeholder="Telephone" name="telephone"
                                       value="{{ $data->telephone }}">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            {{-- Libelle --}}
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="Email" name="email"
                                       value="{{ $data->email }}">
                            </div>
                        </div>

                    </div>
                    <!-- end row 2 -->

                    <!-- row 3 -->
                    <div class="row">

                        <div class="col-lg-6">
                            {{-- Adresse --}}
                            <div class="form-group">
                                <label>Adresse</label>
                                <textarea type="text" class="form-control" rows="2" placeholder="Adresse"
                                          name="adresse">{{ $data->adresse }}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            {{-- Description --}}
                            <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" class="form-control" rows="5" placeholder="Description"
                                          name="description">{{ $data->description }}</textarea>
                            </div>
                        </div>

                    </div>
                    <!-- end row 3 -->

                    <!-- row 4 -->
                    <div class="row" align="center">
                        <div>
                            {{-- Submit & Reset --}}
                            <button type="submit" name="submit" value="valider" class="btn btn-default">Valider
                            </button>
                            </button>
                            <button type="reset" class="btn btn-default">Renitialiser</button>
                        </div>
                    </div>
                    <!-- end row 4 -->


                </form>
                {{-- ************** /.formulaire **************** --}}

            </div>
        </div>
    </div>
    <!-- /.row -->
@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection

@section('styles')
    <link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="{{  asset('js/jquery.js') }}"></script>
    <script src="{{  asset('js/bootstrap.js') }}"></script>
@endsection