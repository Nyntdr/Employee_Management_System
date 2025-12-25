@extends('layouts.employee_navbar')
@section('title', 'All Events')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="h3 mb-0">Events List</h1>
                <p class="text-muted mb-0">All company events and announcements</p>
            </div>
        </div>
        @include('layouts.components.alert')
{{--        @include('layouts.components.search', ['route' => route('employee.events.index'),'placeholder' => 'Search event by name or creator or event date(YYYY-MM-DD)...'])--}}
{{--        <input type="text" id="employee-event-search" class="form-control" placeholder="Search event by name or creator or event date(YYYY-MM-DD)..." autocomplete="off"><br>--}}
        <input type="text" id="employee-event-search" class="form-control" placeholder="Search event by name or creator or event date(YYYY-MM-DD)..." autocomplete="off"><br>
        <div id="employee-event-results">
            @include('employee.events.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'employee-event-search','result' => 'employee-event-results','route' => route('employee.events.index')])

@endsection
