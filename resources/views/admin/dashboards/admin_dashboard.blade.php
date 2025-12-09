@extends('layouts.navbars')
@section('content')
        <h1 class="text-3xl font-bold underline">
      Hello world!
    </h1>
        <h1>Welcome to the managing dashboard admin/ hr.</h1>
        <h1>{{ Auth::user()->name }}</h1>
        <p>Manage the employees from here.</p>
        <a href="{{ route('roles.index') }}">See roles </a> <br>
        <a href="{{ route('departments.index') }}">See departments </a> <br>
        <a href="{{ route('employees.index') }}">See employees </a>

       
@endsection
