@extends('layouts.navbars')

@section('title', 'Update Event')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Update Event</h1>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('events.update', $event->event_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if($errors->any())
                                <div class="form-alert form-alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="title" class="form-label form-label-required">Title</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                           value="{{ old('title', $event->title) }}" required>
                                    @error('title')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" rows="5" class="form-control">{{ old('description', $event->description) }}</textarea>
                                    @error('description')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-6">
                                    <label for="event_date" class="form-label form-label-required">Event Date</label>
                                    <input type="date" name="event_date" id="event_date" class="form-control"
                                           value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" required>
                                    @error('event_date')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-col-3">
                                    <label for="start_time" class="form-label">Start Time</label>
                                    <input type="time" name="start_time" id="start_time" class="form-control"
                                           value="{{ old('start_time', optional($event->start_time)->format('H:i')) }}">
                                    @error('start_time')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-col-3">
                                    <label for="end_time" class="form-label">End Time</label>
                                    <input type="time" name="end_time" id="end_time" class="form-control"
                                           value="{{ old('end_time', optional($event->end_time)->format('H:i')) }}">
                                    @error('end_time')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-btn-group">
                                <a href="{{ route('events.index') }}" class="form-btn-outline">
                                    Go Back
                                </a>
                                <button type="submit" class="form-btn-primary">
                                    Update Event
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
