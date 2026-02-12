@extends('layouts.employee_navbar')
@section('title', 'Request Assets')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="h3 mb-0">Available Assets Lists</h1>
                <p class="text-muted mb-0">Request company assets and equipments for your workplace</p>
            </div>
            <div>
                <a href="{{ route('employee.assets.index') }}" class="btn btn-midnight">My Assets</a>
            </div>
        </div>
        @include('layouts.components.alert')
        <input type="text" id="available-asset-search" class="form-control" placeholder="Search asset by name, code, category, status, condition or type ..." autocomplete="off"><br>
        <div id="available-asset-results">
            @include('employee.assets.available_table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'available-asset-search','result' => 'available-asset-results','route' => route('asset-requests.index')])

@endsection
