@extends('layouts.employee_navbar')
@section('title','Salaries')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="text-midnight mb-2">My Salary Records</h1>
                <p class="text-muted mb-0">Your salary records in the company</p>
            </div>
        </div>
        @include('layouts.components.alert')

        <input type="text" id="employee-payroll-search" class="form-control" placeholder="Search your record by date(YYYY-MM), net salary, generator or status..." autocomplete="off"><br>
        <div id="employee-payroll-results">
            @include('employee.salaries.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'employee-payroll-search','result' => 'employee-payroll-results','route' => route('employee.salaries.index')])

@endsection
