@extends('layouts.main_master')

@section('title') Profile @endsection

@section('main_content')
    <br>

    @include('layouts.alerts')

    <div class="col-lg-2"></div>
    <form method="POST" action="{{ route('admin.submitUpdateUserPassword') }}">
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
                                       value="{{ \App\Models\User::getRole($data->id) }}">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $data->email }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" placeholder="Password" name="password" required>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="panel-footer" align="center">
                    <input type="submit" value="Valider" class="btn btn-outline btn-primary">
                </div>
            </div>
        </div>
    </form>
    <div class="col-lg-2"></div>
@endsection

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection