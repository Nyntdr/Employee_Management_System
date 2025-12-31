@extends('layouts.employee_navbar')
@section('title','All Notices')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="text-midnight mb-2">Notices List</h1>
                <p class="text-muted mb-0">All company notices and announcements</p>
            </div>
        </div>
        @include('layouts.components.alert')
{{--        @include('layouts.components.search', ['route' => route('employee.notices.index'),'placeholder' => 'Search notice by name or poster......'])--}}
        <input type="text" id="employee-notice-search" class="form-control" placeholder="Search notice by name or poster......" autocomplete="off"><br>
        <div id="employee-notice-results">
            @include('employee.notices.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'employee-notice-search','result' => 'employee-notice-results','route' => route('employee.notices.index')])
@endsection
