@extends('layouts.main_master')

@section('title') Modifier agent : {{ $data->nom }} {{ $data->prenom }} @endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Modifier un agent</h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Gestion des Articles</li>
                    <li class="breadcrumb-item"><a href="{{ route('magas.lister',['p_table' => 'agents' ]) }}">Liste des
                            agents</a></li>
                    <li class="breadcrumb-item active ">{{ $data->nom }} {{ $data->prenom }}</li>
                </ol>

                @include('layouts.alerts')

                {{-- *************** formulaire ***************** --}}
                <form role="form" method="post"
                      action="{{ Route('magas.submitUpdate',['p_table' => 'agents']) }}">
                    {{ csrf_field() }}

                    <input type="hidden" class="form-control" name="id_agent" value="{{ $data->id_agent }}">

                    <!-- Row 1 -->
                    <div class="row">

                        <div class="col-lg-3">
                            {{-- Categorie --}}
                            <div class="form-group">
                                <label>fournisseur</label>
                                <select class="form-control" name="id_fournisseur" autofocus>
                                    @if( !$fournisseurs->isEmpty() )
                                        @foreach( $fournisseurs as $item )
                                            <option value="{{ $item->id_fournisseur }}"
                                                    @if( $item->id_fournisseur ==  $data->id_fournisseur  ) selected @endif > {{ $item->libelle }}
                                                {{-- DB::table('articles')->whereIdCategorie($item->id_categorie)->count() --}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            {{-- Nom --}}
                            <div class="form-group">
                                <label>Nom *</label>
                                <input type="text" class="form-control" placeholder="Nom " name="nom"
                                       value="{{ $data->nom }}" required>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            {{-- Prenom --}}
                            <div class="form-group">
                                <label>Prenom</label>
                                <input type="text" class="form-control" placeholder="Prenom " name="prenom"
                                       value="{{ $data->prenom }}" required>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            {{-- Role --}}
                            <div class="form-group">
                                <label>Role *</label>
                                <input type="text" class="form-control" placeholder="Role " name="role"
                                       value="{{ $data->role }}">
                            </div>
                        </div>

                    </div>
                    <!-- end row 1 -->

                    <div class="row">
                        <div class="col-lg-3">
                            {{-- Telephone --}}
                            <div class="form-group">
                                <label>Telephone</label>
                                <input type="text" class="form-control" placeholder="Telephone " name="telephone"
                                       value="{{ $data->telephone }}">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            {{-- Email --}}
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" placeholder="Email " name="email"
                                       value="{{ $data->email }}">
                            </div>
                        </div>
                    </div>


                    <!-- row 4 -->
                    <div class="row" align="center">
                        <button type="submit" name="submit" value="valider" class="btn btn-default">Valider</button>
                        <button type="reset" class="btn btn-default">Effacer</button>
                    </div>
                    <!-- end row 4 -->


                </form>

            </div>
        </div>
    </div>
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