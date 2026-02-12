@extends('layouts.navbars')
@section('title','Attendance')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="text-midnight mb-2">Attendance List</h1>
                <p class="text-muted mb-0">Manage employee attendance records</p>
            </div>
            <a href="{{ route('attendances.create') }}" class="btn btn-midnight">Add Attendance</a>
        </div>

        @include('layouts.components.alert')
        @include('layouts.components.import_export', ['import' => route('attendances.import'),'export' => route('attendances.export')])
{{--        @include('layouts.components.search', ['route' => route('attendances.index'),'placeholder' => 'Search records by name, date(YYYY-MM-DD), clock times(HH:MM) or status...'])--}}
        <input type="text" id="attendance-search" class="form-control" placeholder="Search records by name, date(YYYY-MM-DD), clock times(HH:MM) or status..." autocomplete="off"><br>
        <div id="attendance-results">
            @include('admin.attendances.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'attendance-search','result' => 'attendance-results','route' => route('attendances.index')])

@endsection
