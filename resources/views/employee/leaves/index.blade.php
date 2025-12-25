@extends('layouts.employee_navbar')
@section('title','Leaves')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="h3 mb-0">My Leaves</h1>
                <p class="text-muted mb-0">View your leave requests</p>
            </div>
            <a href="{{route('leave-requests.create')}}" class="btn btn-primary">Request Leave</a>
        </div>
        @include('layouts.components.alert')
{{--        @include('layouts.components.search', ['route' => route('employee.leaves.index'),'placeholder' => 'Search records by reason, leave type, status or approver...'])--}}
        <input type="text" id="employee-leave-search" class="form-control" placeholder="Search records by reason, leave type, status or approver..." autocomplete="off"><br>
        <div id="employee-leave-results">
            @include('employee.leaves.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'employee-leave-search','result' => 'employee-leave-results','route' => route('employee.leaves.index')])

@endsection
