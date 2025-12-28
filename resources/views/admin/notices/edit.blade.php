@extends('layouts.navbars')

@section('title', 'Update Notice')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Edit Notice</h1>
                        <p class="mb-0 form-text-muted">Notice ID: NTC-{{ str_pad($notice->notice_id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('notices.update', $notice->notice_id) }}" method="POST">
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
                                    <input type="text" name="title" id="title"
                                           class="form-control"
                                           value="{{ old('title', $notice->title) }}"
                                           required
                                           placeholder="Enter notice title">
                                    @error('title')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="content" class="form-label form-label-required">Content</label>
                                    <textarea name="content" id="content"
                                              class="form-control"
                                              rows="5"
                                              required
                                              placeholder="Enter notice content">{{ old('content', $notice->content) }}</textarea>
                                    @error('content')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-btn-group">
                                <a href="{{ route('notices.index') }}" class="form-btn-outline">
                                    Back to Notices
                                </a>
                                <button type="submit" class="form-btn-primary">
                                    Update Notice
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
