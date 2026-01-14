@extends('layouts.employee_navbar')
@section('title','Attendance')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="text-midnight mb-2">My Attendance</h1>
                <p class="text-muted mb-0">Your attendance record with total hours worked everyday and status</p>
            </div>
        </div>
        @include('layouts.components.alert')
{{--        @include('layouts.components.search', ['route' => route('employee.attendances.index'),'placeholder' => 'Search records by date(YYYY-MM-DD), clock times(HH:MM) or status...'])--}}
        <input type="text" id="employee-attendance-search" class="form-control" placeholder="Search records by date(YYYY-MM-DD), clock times(HH:MM) or status..." autocomplete="off"><br>
        <div id="employee-attendance-results">
            @include('employee.attendances.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'employee-attendance-search','result' => 'employee-attendance-results','route' => route('employee.attendances.index')])

@endsection
