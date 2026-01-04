@extends('layouts.navbars')
@section('title', 'All Events')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="text-midnight mb-2">Events List</h1>
                <p class="text-muted mb-0">Manage company events and announcements</p>
            </div>
            <a href="{{ route('events.create') }}" class="btn btn-midnight">Create Event</a>
        </div>
        @include('layouts.components.alert')
        @include('layouts.components.import_export', ['import' => route('events.import'),'export' => route('events.export')])
{{--        @include('layouts.components.search', ['route' => route('events.index'),'placeholder' => 'Search event by name or creator or event date(YYYY-MM-DD)...'])--}}
        <input type="text" id="event-search" class="form-control" placeholder="Search event by name or creator or event date(YYYY-MM-DD)..." autocomplete="off"><br>
        <div id="event-results">
            @include('admin.events.table')
        </div>
    </div>
    @include('layouts.components.search_script',['search'=>'event-search','result' => 'event-results','route' => route('events.index')])

@endsection
