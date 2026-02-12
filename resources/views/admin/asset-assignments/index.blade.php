@extends('layouts.navbars')
@section('title', 'All Assigned Assets')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="text-midnight mb-2">Assigned Assets</h1>
                <p class="text-muted mb-0">Manage asset assignments to employees</p>
            </div>
            <div>
                <a href="{{ route('assets.index') }}" class="btn btn-success">Assets</a>
                <a href="{{ route('asset-assignments.create') }}" class="btn btn-midnight">Assign Asset</a>
            </div>
        </div>
        @include('layouts.components.alert')
        @include('layouts.components.import_export', ['import' => route('asset-assignments.import'),'export' => route('asset-assignments.export')])
        {{--        @include('layouts.components.search', ['route' => route('asset-assignments.index'),'placeholder' => 'Search assets assigned by name, code, status, condition or assigner...'])--}}
        <input type="text" id="asset-assignment-search" class="form-control"
               placeholder="Search assets assigned by name, code, status, condition or assigner..."
               autocomplete="off"><br>
        <div id="asset-assignment-results">
            @include('admin.asset-assignments.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'asset-assignment-search','result' => 'asset-assignment-results','route' => route('asset-assignments.index')])
@endsection
