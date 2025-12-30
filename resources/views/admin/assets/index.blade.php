@extends('layouts.navbars')
@section('title', 'All Assets')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="text-midnight mb-2">Assets List</h1>
                <p class="text-muted mb-0">Manage company assets and equipment</p>
            </div>
            <div>
                <a href="{{ route('assets.create') }}" class="btn btn-primary me-2">Add Asset</a>
                <a href="{{ route('asset-assignments.index') }}" class="btn btn-outline-secondary">Assign Assets</a>
            </div>
        </div>
        @include('layouts.components.alert')
        @include('layouts.components.import_export', ['import' => route('assets.import'),'export' => route('assets.export')])
{{--        @include('layouts.components.search', ['route' => route('assets.index'),'placeholder' => 'Search asset by name, code, category, status, condition or type ...'])--}}
        <input type="text" id="asset-search" class="form-control" placeholder="Search asset by name, code, category, status, condition or type ..." autocomplete="off"><br>
        <div id="asset-results">
            @include('admin.assets.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'asset-search','result' => 'asset-results','route' => route('assets.index')])

@endsection
