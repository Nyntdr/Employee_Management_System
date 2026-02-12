@extends('layouts.navbars')
@section('title','Leaves')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="text-midnight mb-2">Leave Records</h1>
                <p class="text-muted mb-0">Manage employee leave requests</p>
            </div>
            <div class="d-flex gap-1">
                <a href="{{ route('leave-types.index') }}" class="btn btn-success">Leave Types</a>
                <a href="{{ route('leaves.create') }}" class="btn btn-midnight">Add Leave</a>
            </div>
        </div>
        @include('layouts.components.alert')
        @include('layouts.components.import_export', ['import' => route('leaves.import'),'export' => route('leaves.export')])
{{--        @include('layouts.components.search', ['route' => route('leaves.index'),'placeholder' => 'Search records by name, reason, leave type, status or approver...'])--}}
        <input type="text" id="leave-search" class="form-control" placeholder="Search records by name, reason, leave type, status or approver..." autocomplete="off"><br>
        <div id="leave-results">
            @include('admin.leaves.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'leave-search','result' => 'leave-results','route' => route('leaves.index')])

@endsection
