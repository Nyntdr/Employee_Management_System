@extends('layouts.navbars')
@section('title','All Departments')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="text-midnight mb-2">Department List</h1>
                <p class="text-muted mb-0">Manage employee departments</p>
            </div>
            <a href="{{ route('departments.create') }}" class="btn btn-midnight">
                Add Department
            </a>
        </div>

        @include('layouts.components.alert')
        @include('layouts.components.import_export', ['import' => route('departments.import'),'export' => route('departments.export')])
{{--        @include('layouts.components.search', ['route' => route('departments.index'),'placeholder' => 'Search by department name or manager name...'])--}}
        <input type="text" id="department-search" class="form-control" placeholder="Search by department name or manager name..." autocomplete="off"><br>
        <div id="department-results">
            @include('admin.departments.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'department-search','result' => 'department-results','route' => route('departments.index')])

@endsection
