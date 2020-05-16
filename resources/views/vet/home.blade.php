@extends('adminlte::page')

@section('title', 'Maya :: Veterinário')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Seja bem vindo(a) Dr(a). {{auth()->user()->name}} !!! </p>
@stop
