@extends('layouts.main_master')

@section('title') Agent: {{ $data->nom }} {{ $data->prenom }} @endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Agent</h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item ">Gestion des Articles</li>
                    <li class="breadcrumb-item"><a href="{{ route('magas.lister',['p_table' => 'agents' ]) }}">Liste
                            des agents</a></li>
                    <li class="breadcrumb-item active">{{ $data->nom }} {{ $data->prenom }}</li>
                </ol>


                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <!-- debut panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading" align="center">
                                <h2>{{ $data->nom }} {{ $data->prenom }}
                                    <small>{{ $data->role }}</small>
                                </h2>
                            </div>

                            <!-- debut panel body -->
                            <div class="panel-body">
                                <table class="table table-hover" border="0" cellspacing="0" cellpadding="5">

                                    <tr>
                                        <td>Fournisseur</td>
                                        <th>{{ \App\Models\Fournisseur::getLibelle($data->id_fournisseur) }} </th>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <th>{{ $data->email }} </th>
                                    </tr>
                                    <tr>
                                        <td>Telephone</td>
                                        <th>{{ $data->telephone }} </th>
                                    </tr>
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
                                    <tr>
                                        <td>nombre d'articles dans la catégorie</td>
                                        <td>
                                            <strong>{{ App\Models\Article::whereIdCategorie($data->id_categorie)->Where('deleted',false)->count() }} </strong>
                                        </td>
                                    </tr>
                                </table>

                                @if( strlen($data->description) > 0 )
                                    <div class="page-header">
                                        <h3>Description</h3>
                                    </div>
                                    <div class="well">
                                        <p>{{ $data->description }}</p>
                                    </div>
                                @endif


                                <div class="row" align="center">
                                    <a href="{{ Route('magas.delete',['p_table' => 'agents', 'p_id' => $data->id_agent ]) }}"
                                       onclick="return confirm('Êtes-vous sure de vouloir effacer l\'agent: {{ $data->nom }} {{ $data->prenom }} ?')"
                                       type="button" class="btn btn-outline btn-danger"
                                            {!! setPopOver("","Supprimer la categorie") !!}>Supprimer </a>
                                    <a href="{{ Route('magas.update',['p_table' => 'agents', 'p_id' => $data->id_agent ]) }}"
                                       type="button" class="btn btn-outline btn-info"
                                            {!! setPopOver("","Modifier l'agent") !!}> Modifier </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                </div>
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