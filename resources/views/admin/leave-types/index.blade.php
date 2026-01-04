@extends('layouts.navbars')
@section('title','Leave Types')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="text-midnight mb-2">Leave Types</h1>
                <p class="text-muted mb-0">Manage different types of leave</p>
            </div>

            <div class="d-flex gap-1">
                <a href="{{ route('leaves.index') }}" class="btn btn-success">Leave Records</a>
                <a href="{{ route('leave-types.create') }}" class="btn btn-midnight">Add Type</a>
            </div>
        </div>
        @include('layouts.components.alert')
        @include('layouts.components.import_export', ['import' => route('leave-types.import'),'export' => route('leave-types.export')])
{{--        @include('layouts.components.search', ['route' => route('leave-types.index'),'placeholder' => 'Search leave type by name...'])--}}
        <input type="text" id="leave-type-search" class="form-control" placeholder="Search leave type by name..." autocomplete="off"><br>
        <div id="leave-type-results">
            @include('admin.leave-types.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'leave-type-search','result' => 'leave-type-results','route' => route('leave-types.index')])

@endsection
