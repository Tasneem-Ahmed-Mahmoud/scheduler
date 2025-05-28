@extends('user.layout')

@section('content')
<div class="container py-5">
    <!-- Navigation -->
   

    <!-- Post Form Card -->
    <div class="card shadow-sm rounded p-3 bg-white">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-semibold">Post Details</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('user.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <!-- Main Form Column -->
                    <div class="col-lg-8">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">
                                Title <small class="text-muted" id="titleCounter"></small>
                            </label>
                            <input type="text" name="title" id="title" maxlength="100"
                                class="form-control @error('title') is-invalid @enderror" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-3">
                            <label for="content" class="form-label fw-semibold">Content</label>
                            <textarea name="content" id="content" rows="6"
                                class="form-control @error('content') is-invalid @enderror" required></textarea>
                            <x-error field="content" />
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label fw-semibold">Image URL (Optional)</label>
                            <input type="file" name="image" id="image"
                                class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            <x-error field="image" />
                        </div>

                        <!-- Scheduled Time -->
                        <div class="mb-3">
                            <label for="scheduled_time" class="form-label fw-semibold">Scheduled Time</label>
                            <input type="datetime-local" name="scheduled_time" id="scheduled_time"
                                class="form-control @error('scheduled_time') is-invalid @enderror" required>
                            <x-error field="scheduled_time" />
                        </div>
                    </div>

                    <!-- Sidebar Column -->
                    <div class="col-lg-4">
                        <!-- Status -->
                        <div class="card mb-4">
                            <div class="card-header bg-light fw-semibold">Status</div>
                            <div class="card-body">
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="draft">Draft</option>
                                    <option value="scheduled">Scheduled</option>
                                </select>
                                <x-error field="status" />
                            </div>
                        </div>

                        <!-- Platforms -->
                        <div class="card mb-4">
                            <div class="card-header bg-light fw-semibold">Platforms</div>
                            <div class="card-body">
                                @foreach ($platforms as $platform)
                                    <div class="form-check mb-2">
                                        <input type="checkbox" name="platform_ids[]" value="{{ $platform->id }}"
                                            class="form-check-input" id="platform_{{ $platform->id }}">
                                        <label for="platform_{{ $platform->id }}" class="form-check-label">
                                            {{ $platform->name }}
                                            <small class="text-muted">{{ $platform->limit }} </small>
                                        </label>
                                    </div>
                                @endforeach
                                <x-error field="platform_id" />
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Create Post
                            </button>
                            <a href="{{ route('user.posts.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
