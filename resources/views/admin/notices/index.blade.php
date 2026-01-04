@extends('layouts.navbars')
@section('title','All Notices')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="text-midnight mb-2">Notices List</h1>
                <p class="text-muted mb-0">Manage company notices and announcements</p>
            </div>
            <a href="{{ route('notices.create') }}" class="btn btn-midnight">
                Create Notice
            </a>
        </div>
        @include('layouts.components.alert')
        @include('layouts.components.import_export', ['import' => route('notices.import'),'export' => route('notices.export')])
{{--        @include('layouts.components.search', ['route' => route('notices.index'),'placeholder' => 'Search notice by name or poster...'])--}}
        <input type="text" id="notice-search" class="form-control" placeholder="Search notice by name or poster..." autocomplete="off"><br>
        <div id="notice-results">
            @include('admin.notices.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'notice-search','result' => 'notice-results','route' => route('notices.index')])

@endsection
