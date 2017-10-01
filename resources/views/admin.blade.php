@extends('layouts.master')


@section('title')
Admin Page
@endsection


@section('content')
<h1>Hello Mr. Admin</h1>
@endsection



@section('menu_1')
    @include('_nav_menu_1')
@endsection

@section('menu_2')
    @include('_nav_menu_2')
@endsection