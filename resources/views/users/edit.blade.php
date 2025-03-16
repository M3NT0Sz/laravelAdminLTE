@extends('layouts.default')
@section('page-title', 'Edit User')
@section('content')
    @include('users.parts.basic-details')
    <br>
    @include('users.parts.profile')
    <br>
    @include('users.parts.interests')
    <br>
    @include('users.parts.roles')
@endsection