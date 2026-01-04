@extends('layouts.navbars')
@section('title','All Employees')
@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="text-midnight mb-2">Employee List</h1>
                <p class="text-muted mb-0">Manage employee records</p>
            </div>
            <a href="{{ route('employees.create') }}" class="btn btn-midnight">Add Employee</a>
        </div>
        @include('layouts.components.alert')
        <div class="row mb-3 import-export-row">
            <div class="col-md-6">
                <div class="d-flex align-items-center gap-2 btn-gap">
                    <a href="{{ route('roles.index') }}" class="btn btn-warning">Roles</a>
                    <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data"
                          class="d-inline">
                        @csrf
                        <input type="file" name="file" id="importFile" class="d-none" accept=".csv,.xlsx,.xls" required
                               onchange="this.form.submit()">
                        <button type="button" onclick="document.getElementById('importFile').click()"
                                class="btn btn-midnight">
                            Import
                        </button>
                    </form>
                    <a href="{{ route('employees.export') }}" class="btn btn-success">Export</a>
                </div>
            </div>
        </div>
        {{--        @include('layouts.components.search', ['route' => route('employees.index'),'placeholder' => 'Search employee by name, email or phone number...'])--}}
        <input type="text" id="employee-search" class="form-control" placeholder="Search employee by name, email, department or phone number..." autocomplete="off"><br>
        <div id="employee-results">
            @include('admin.employees.employee_data')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'employee-search','result' => 'employee-results','route' => route('employees.index')])

@endsection
