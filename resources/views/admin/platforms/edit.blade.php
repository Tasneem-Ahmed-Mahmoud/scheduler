@extends('admin.layout')

@section('content')
    <div class="container">
        <h2>Create Platform</h2>
        <form action="{{ route('admin.platforms.update', $platform) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Platform Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $platform->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Platform Type</label>
                <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror"
                    value="{{ old('type', $platform->type) }}" required>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Post Words Count <span style="color:red">(Leave blank for unlimited) </span></label>
                <input type="text" name="max_post_words_count" id="max_post_words_count"
                    class="form-control @error('max_post_words_count') is-invalid @enderror"
                    value="{{ old('max_post_words_count', $platform->max_post_words_count) }}" >
                @error('max_post_words_count')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input type="checkbox" name="allow_post_without_image" id="allow_post_without_image"
                    class="form-check-input @error('allow_post_without_image') is-invalid @enderror"
                    @if (old('allow_post_without_image', $platform->allow_post_without_image)) checked @endif >
                <label for="allow_post_without_image" class="form-label">Allow Post Without Image</label>

                @error('allow_post_without_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
