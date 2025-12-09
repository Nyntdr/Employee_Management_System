@extends('layouts.navbars')
@section('content')
        <h1 class="text-3xl font-bold underline">
      Hello world!
    </h1>
        <h1>Welcome to the managing dashboard admin/ hr.</h1>
        <h1>{{ Auth::user()->name }}</h1>
        <p>Manage the employees from here.</p>
        <p>Role, Department, Notices have all CRUDs. Navs are clickable. </p>
        <h3>Click on the nav with ✅ for viewing more about them.</h3>
@endsection
