@extends('layouts.navbars')
@section('title','Salaries')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="text-midnight mb-2">Salary Records</h1>
                <p class="text-muted mb-0">Manage employee salary and payroll</p>
            </div>
            <a href="{{ route('payrolls.create') }}" class="btn btn-primary">Add Salary Record</a>
        </div>
        @include('layouts.components.alert')
        @include('layouts.components.import_export', ['import' => route('payrolls.import'),'export' => route('payrolls.export')])
{{--        @include('layouts.components.search', ['route' => route('payrolls.index'),'placeholder' => 'Search by month, employee name, net salary, generator or status...'])--}}
        <input type="text" id="payroll-search" class="form-control" placeholder="Search by month(YYYY-MM), employee name, net salary, generator or status..." autocomplete="off"><br>
        <div id="payroll-results">
            @include('admin.salaries.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'payroll-search','result' => 'payroll-results','route' => route('payrolls.index')])

@endsection
