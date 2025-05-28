@extends('user.layout')

@section('content')
<div class="min-vh-100 bg-light">

    {{-- Main Content --}}
    <div class="container py-5">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary mb-0">📋 Manage Posts</h2>
            <a href="{{ route('user.posts.create') }}" class="btn btn-success shadow">
                <i class="bi bi-plus-circle me-1"></i>
                Create Post
            </a>
        </div>

        {{-- Filters --}}
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-primary text-white fw-semibold">
                <i class="bi bi-funnel-fill me-1"></i> Filters
            </div>
            <div class="card-body bg-light">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-select shadow-sm">
                            <option value="">All Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="from" class="form-label">From</label>
                        <input type="date" name="from" class="form-control shadow-sm" value="{{ request('from') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="to" class="form-label">To</label>
                        <input type="date" name="to" class="form-control shadow-sm" value="{{ request('to') }}">
                    </div>
                    <div class="col-2">
                      
                        <button class="btn btn-outline-primary ">
                            <i class="bi bi-search me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Posts Table --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom fw-semibold">
                <i class="bi bi-list-ul me-1 text-primary"></i> Posts List
            </div>
            <div class="card-body p-0">
                @if ($posts->count())
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="bi bi-type me-1 text-muted"></i> Title</th>
                                    <th><i class="bi bi-check2-circle me-1 text-muted"></i> Status</th>
                                    <th><i class="bi bi-clock me-1 text-muted"></i> Scheduled Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr class="table-row">
                                        <td class="fw-semibold">{{ $post->title }}</td>
                                        <td>
                                            <span class="badge rounded-pill px-3
                                                @if ($post->status == 'draft') bg-secondary
                                                @elseif ($post->status == 'scheduled') bg-warning text-dark
                                                @elseif ($post->status == 'published') bg-success
                                                @endif">
                                                {{ ucfirst($post->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $post->scheduled_time ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-exclamation-circle display-6 text-muted"></i>
                        <p class="text-muted mt-2 mb-0">No posts found matching your criteria.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
