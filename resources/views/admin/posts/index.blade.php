@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Posts</h2>

    <form method="GET" class="row mb-3">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">-- Status --</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Scheduled For</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>
                    <span class="badge 
                        @if($post->status === 'draft') bg-secondary
                        @elseif($post->status === 'scheduled') bg-warning
                        @elseif($post->status === 'published') bg-success
                        @endif">
                        {{ ucfirst($post->status) }}
                    </span>
                </td>
                <td>{{ $post->scheduled_time ? Carbon\Carbon::parse($post->scheduled_time)->format('Y-m-d H:i') : '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $posts->links() }}
</div>
@endsection
