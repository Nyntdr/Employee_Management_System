@extends('layouts.navbars')
@section('content')
        <h1 class="text-3xl font-bold underline">
      Hello world!
    </h1>
        <h2>Welcome to the managing dashboard admin/ hr.</h2>
        <h1>{{ Auth::user()->name }}</h1>
        <p>Manage the employees from here.</p>
        <p>Total Users: <strong>{{ $totalUsers }}</strong></p>
        <p>Total Departments: <strong>{{ $totalDepartments }}</strong></p>
        <p>Total Employees: <strong>{{ $totalEmployees }}</strong></p>
@endsection
