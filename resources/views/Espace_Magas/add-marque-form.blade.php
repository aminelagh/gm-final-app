@extends('layouts.main_master')

@section('title') Nouvelle marque @endsection

@section('main_content')

    <h1 class="page-header">Ajouter une marque</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des Articles</li>
        <li class="breadcrumb-item"><a href="{{ Route('magas.marques') }}">
                Liste des marques</a></li>
        <li class="breadcrumb-item active">Création d'une marque</li>
    </ol>


    <form role="form" method="post" enctype="multipart/form-data"
          action="{{ Route('magas.submitAddMarque') }}">
        {{ csrf_field() }}

        <div class="panel panel-default">

            <div class="panel-heading">
                Nouvelle marque
            </div>
            <div class="panel-body">
                <div class="row">

                    {{-- Libelle --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Marque *</label>
                            <input type="text" class="form-control" placeholder="Libelle " name="libelle"
                                   value="{{ old('libelle') }}" required autofocus>
                        </div>
                    </div>

                    {{-- Image --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Image </label>
                            <input type="file" class="form-control-static" id="imageInput" name="image"/>
                            <img id="showImage" src="#" alt="" width="100px">
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

@section('scripts')
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

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection