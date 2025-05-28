@extends('admin.layout')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Platforms</h2>
        <a href="{{ route('admin.platforms.create') }}" class="btn btn-primary">Add Platform</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Posts Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($platforms as $platform)
            <tr>
                <td>{{ $platform->id }}</td>
                <td>{{ $platform->name }}</td>
                <td>
                    {{ $platform->posts_count }} post
                </td>
                <td>
                    <a href="{{ route('admin.platforms.edit', $platform) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.platforms.destroy', $platform) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
