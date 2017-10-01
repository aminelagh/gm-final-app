@extends('layouts.main_master')

@section('title') Article: {{ $data->designation }} @endsection

@section('main_content')

    <h3 class="page-header">Article</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des Articles</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.articles') }}">Liste
                des articles</a></li>
        <li class="breadcrumb-item active">{{ $data->designation  }}</li>
    </ol>

    <form id="deleteForm" action="{{ route('admin.deleteArticle',[$data->id_article]) }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="DELETE" form="deleteForm">

    </form>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

            <form method="POST" action="{{ route('admin.submitUpdateArticle') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="id_article" value="{{ $data->id_article }}">

                <div class="panel panel-default">
                    <div class="panel-heading" align="center">
                        <h4><b>{{ $data->designation }}</b></h4>
                        @if($data->deleted==true)
                            <h5>Deleted</h5>
                        @endif
                    </div>
                    <div class="panel-body">

                        <table class="table table-hover">

                            <tr>
                                <td>Article</td>
                                <th><input class="form-control" type="text" name="designation"
                                           value="{{ $data->designation }}" required>
                                </th>
                            </tr>
                            <tr>
                                <td>Marque</td>
                                <th>
                                    <select class="form-control" name="id_marque">
                                        @if( !$marques->isEmpty() )
                                            @foreach( $marques as $item )
                                                <option value="{{ $item->id_marque }}"
                                                        @if( $item->id_marque == $data->id_marque ) selected @endif > {{ $item->libelle }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </th>
                            </tr>
                            <tr>
                                <td>Categorie</td>
                                <th>
                                    <select class="form-control" name="id_categorie">
                                        @if( !$categories->isEmpty() )
                                            @foreach( $categories as $item )
                                                <option value="{{ $item->id_categorie }}"
                                                        @if( $item->id_categorie == $data->id_categorie ) selected @endif > {{ $item->libelle }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </th>
                            </tr>
                            <tr>
                                <td>Fournisseur</td>
                                <th>
                                    <select class="form-control" name="id_fournisseur">
                                        @if( !$fournisseurs->isEmpty() )
                                            @foreach( $fournisseurs as $item )
                                                <option value="{{ $item->id_fournisseur }}"
                                                        @if( $item->id_fournisseur == $data->id_fournisseur ) selected @endif > {{ $item->libelle }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </th>
                            </tr>
                            <tr>
                                <td>Code</td>
                                <th><input class="form-control" type="text" name="code" placeholder="Code"
                                           value="{{ $data->code }}">
                                </th>
                            </tr>
                            <tr>
                                <td>Reference</td>
                                <th>
                                    <div class="col-lg-5">
                                        <input class="form-control" type="text" name="ref" value="{{ $data->ref }}"
                                               required>

                                    </div>
                                    <div class="col-lg-1">-</div>
                                    <div class="col-lg-3">
                                        <input class="form-control" type="text" name="alias" value="{{ $data->alias }}">
                                    </div>

                                </th>
                            </tr>

                            <tr>
                                <td>Couleur</td>
                                <th><input class="form-control" type="text" name="couleur"
                                           value="{{ $data->couleur }}">
                                </th>
                            </tr>
                            <tr>
                                <td>Sexe</td>
                                <th>
                                    <select class="form-control" name="sexe">
                                        <option value="aucun" {{ $data->sexe =="aucun" ? 'selected' : '' }}>
                                            <i>aucun</i></option>
                                        <option value="Homme" {{ $data->sexe =="Homme" ? 'selected' : '' }}>Homme
                                        </option>
                                        <option value="Femme" {{ $data->sexe =="Femme" ? 'selected' : '' }}>Femme
                                        </option>
                                        <option value="Enfant" {{ $data->sexe =="Enfant" ? 'selected' : '' }}>
                                            Enfant
                                        </option>
                                    </select>
                                </th>
                            </tr>
                            <tr>
                                <td>Prix d'achat (HT)</td>
                                <th><input type="number" step="0.01" pattern=".##" min="0" class="form-control"
                                           placeholder="Prix d'achat" name="prix_a"
                                           value="{{ $data->prix_a }}">
                                </th>
                            </tr>
                            <tr>
                                <td>Prix de vente (HT)</td>
                                <th><input type="number" step="0.01" pattern=".##" min="0" class="form-control"
                                           placeholder="Prix de vente" name="prix_v"
                                           value="{{ $data->prix_v }}">
                                </th>
                            </tr>
                            @if($data->image!=null)
                                <tr>
                                    <td>Image</td>
                                    <td>
                                        <img src="{{ asset($data->image) }}" height="70" width="80">
                                        <input type='file' id="imageInput" name="image"
                                               {!! setPopOver("Image","Cliquez ici pour choisir la nouvelle image") !!} }}/>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td>Image</td>
                                    <td>
                                        <input type='file' id="imageInput" name="image"
                                               {!! setPopOver("Image","Cliquez ici pour choisir la nouvelle image") !!} }}/>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td>Date de creation</td>
                                <th>{{ getDateHelper($data->created_at) }}
                                    a {{ getTimeHelper($data->created_at) }}   </th>
                            </tr>
                            <tr>
                                <td>Date de derniere modification</td>
                                <th>{{ getDateHelper($data->updated_at) }}
                                    a {{ getTimeHelper($data->updated_at) }}     </th>
                            </tr>
                        </table>
                    </div>
                    <div class="panel-footer" align="center">
                        <input type="submit" value="Valider"
                               class="btn btn-primary" {!! setPopOver("","Valider les modification") !!}>
                        <input type="reset" value="Réinitialiser"
                               class="btn btn-outline btn-primary" {!! setPopOver("","Valider les modification") !!}>
                        <button type="submit" class="btn btn-danger btn-outline" form="deleteForm">
                            Supprimer
                        </button>
                    </div>
                </div>

            </form>
        </div>
        <div class="col-lg-1"></div>
    </div>
@endsection


@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection