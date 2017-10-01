@extends('layouts.main_master')

@section('title') {{ $data->designation_c }} @endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Modification d'un Article</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Gestion des Articles</li>
                    <li class="breadcrumb-item"><a href="{{ Route('magas.lister',['p_table' => 'articles' ]) }}">Liste
                            des articles</a></li>
                    <li class="breadcrumb-item active">{{ $data->designation_c }}</li>
                </ol>

                @include('layouts.alerts')

                {{-- *************** formulaire ***************** --}}
                <form enctype="multipart/form-data" role="form" method="post"
                      action="{{ Route('magas.submitUpdate',['p_table' => 'articles']) }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="id_article" value="{{ $data->id_article }}">

                    <!-- Row 1 -->
                    <div class="row">
                        <div class="col-lg-3">
                            {{-- Categorie --}}
                            <div class="form-group">
                                <label>Categorie</label>
                                <select class="form-control" name="id_categorie" autofocus>
                                    @if( !$categories->isEmpty() )
                                        @foreach( $categories as $item )
                                            <option value="{{ $item->id_categorie }}"
                                                    @if( $item->id_categorie == $data->id_categorie ) selected @endif > {{ $item->libelle }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            {{-- Fournisseur --}}
                            <div class="form-group">
                                <label>Fournisseur</label>
                                <select class="form-control" name="id_fournisseur">
                                    @if( !$fournisseurs->isEmpty() )
                                        @foreach( $fournisseurs as $item )
                                            <option value="{{ $item->id_fournisseur }}"
                                                    @if( $item->id_fournisseur == $data->id_fournisseur ) selected @endif > {{ $item->libelle }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            {{-- Marque --}}
                            <div class="form-group">
                                <label>Marque</label>
                                <select class="form-control" name="id_marque">
                                    @if( !$marques->isEmpty() )
                                        @foreach( $marques as $item )
                                            <option value="{{ $item->id_marque }}"
                                                    @if( $item->id_marque == $data->id_marque ) selected @endif > {{ $item->libelle }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                    </div>
                    <!-- end row 1 -->

                    <!-- Row 2 -->
                    <div class="row">
                        <div class="col-lg-3">
                            {{-- num_article --}}
                            <div class="form-group">
                                <label>Numero de l'article *</label>
                                <input type="text" class="form-control" placeholder="Numero Article"
                                       name="num_article" value="{{ $data->num_article }}" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            {{-- code_barre --}}
                            <div class="form-group">
                                <label>Code a Barres *</label>
                                <input type="text" class="form-control" placeholder="Code a Barres"
                                       name="code_barre" value="{{ $data->code_barre }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            {{-- Designation_c --}}
                            <div class="form-group">
                                <label>Designation Courte *</label>
                                <input type="text" class="form-control" placeholder="Designation Courte"
                                       name="designation_c" value="{{ $data->designation_c }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            {{-- Designation_l --}}
                            <div class="form-group">
                                <label>Designation Longue</label>
                                <textarea type="text" class="form-control" rows="2" placeholder="Designation Longue"
                                          name="designation_l">{{ $data->designation_l }}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end row 2 -->

                    <!-- row 3 -->
                    <div class="row">

                        <div class="col-lg-2">
                            {{-- Sexe --}}
                            <div class="form-group">
                                <label>Sexe</label>
                                <select class="form-control" name="sexe">
                                    <option value="aucun" {{$data->sexe=="aucun" ? 'selected' : '' }}> - </option>
                                    <option value="Homme" {{ $data->sexe=="Homme" ? 'selected' : '' }}>Homme</option>
                                    <option value="Femme" {{ $data->sexe=="Femme" ? 'selected' : '' }}>Femme</option>
                                    <option value="Enfant" {{ $data->sexe=="Enfant" ? 'selected' : '' }}>Enfant</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            {{-- Couleur --}}
                            <div class="form-group">
                                <label>Couleur</label>
                                <input type="text" class="form-control" placeholder="Couleur" name="couleur"
                                       value="{{ $data->couleur  }}">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            {{-- Prix achat --}}
                            <div class="form-group">
                                <label>Prix d'achat (HT)</label>
                                <input type="number" step="0.01" pattern=".##" min="0" class="form-control"
                                       placeholder="Prix d'achat" name="prix_achat" value="{{ $data->prix_achat }}">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            {{-- Prix vente --}}
                            <div class="form-group">
                                <label>Prix de Vente (HT)</label>
                                <input type="number" step="0.01" pattern=".##" min="0" class="form-control"
                                       placeholder="Prix de vente" name="prix_vente"
                                       value="{{ $data->prix_vente }}">
                            </div>
                        </div>
                    </div>
                    <!-- end row 3 -->

                    <!-- row 4 -->
                    <div class="row">
                        <div class="col-lg-4">
                            {{-- Image --}}
                            <div class="form-group">
                                <input type='file' class="form-control" id="imageInput" name="image"/>
                                <img id="showImage" src="{{ $data->image or '#' }}" alt="Image de l'article" width="100px" height="100px"/>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            {{-- Submit & Reset --}}
                            <button type="submit" name="submit" value="valider" class="btn btn-default" {!! setPopOver("","cliquez ici pour valider la modification") !!}>Valider
                            </button>
                            <button type="reset" class="btn btn-default" {!! setPopOver("","cliquez ici pour récupérer les valeurs initiales") !!}>Réinitialiser</button>
                        </div>
                    </div>
                    <!-- end row 4 -->

                </form>
                {{-- ************** /.formulaire **************** --}}


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
    <script>
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imageInput").change(function () {
            readURL(this);
        });
    </script>
@endsection
