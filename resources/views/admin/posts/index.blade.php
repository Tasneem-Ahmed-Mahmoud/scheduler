@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Posts</h2>

    <form method="GET" class="row mb-3">
        <div class="col-md-3">
            <label for="title">Title</label>
            <select name="status" class="form-select">
                <option value="">-- Status --</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="from">From</label>
            <input type="text" name="from" class="form-control datetimepicker" value="{{ request('from') }}">
        </div>
        <div class="col-md-3">
            <label for="to">To</label>
            <input type="text" name="to" class="form-control datetimepicker" value="{{ request('to') }}">
        </div>
        <div class="col-md-3 mt-4">
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

   {{ $posts->withQueryString()->links() }}

</div>
@endsection
