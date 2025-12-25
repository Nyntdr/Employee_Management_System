@extends('layouts.employee_navbar')
@section('title', 'Assigned Assets')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="h3 mb-0">My Assigned Assets</h1>
                <p class="text-muted mb-0">View assets assigned to you</p>
            </div>
            <a href="#" class="btn btn-primary">Request Asset</a>
        </div>
        @include('layouts.components.alert')
{{--        @include('layouts.components.search', ['route' => route('employee.assets.index'),'placeholder' => 'Search assets assigned by name, code, status, condition or assigner...'])--}}
        <input type="text" id="employee-asset-search" class="form-control" placeholder="Search assets assigned by name, code, status, condition or assigner..." autocomplete="off"><br>
        <div id="employee-asset-results">
            @include('employee.assets.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'employee-asset-search','result' => 'employee-asset-results','route' => route('employee.assets.index')])

@endsection
