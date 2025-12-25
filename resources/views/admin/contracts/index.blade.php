@extends('layouts.navbars')
@section('title','All Contracts')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="h3 mb-0">Contract List</h1>
                <p class="text-muted mb-0">Manage employee contracts</p>
            </div>
            <a href="{{ route('contracts.create') }}" class="btn btn-primary">Add Contract</a>
        </div>
        @include('layouts.components.alert')
        @include('layouts.components.import_export', ['import' => route('contracts.import'),'export' => route('contracts.export')])
{{--        @include('layouts.components.search', ['route' => route('contracts.index'),'placeholder' => 'Search contract by employee name or contract status or job title ...'])--}}
        <input type="text" id="contract-search" class="form-control" placeholder="Search contract by employee name or contract status or job title ..." autocomplete="off"><br>
        <br>
        <div id="contract-results">
            @include('admin.contracts.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'contract-search','result' => 'contract-results','route' => route('contracts.index')])
@endsection
