@extends('admin.layout')

@section('content')
    <div class="container">
        <h2>Create Platform</h2>
        <form action="{{ route('admin.platforms.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Platform Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Platform Type</label>
                <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror"
                    value="{{ old('type') }}" required>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Post Words Count <span style="color:red">(Leave blank for unlimited) </span></label>
                <input type="text" name="max_post_words_count" id="max_post_words_count"
                    class="form-control @error('max_post_words_count') is-invalid @enderror"
                    value="{{ old('max_post_words_count') }}">
            
                @error('max_post_words_count')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input type="checkbox" name="allow_post_without_image" id="allow_post_without_image"
                    class="form-check-input @error('allow_post_without_image') is-invalid @enderror"
                    value="{{ old('allow_post_without_image') }}">
                <label for="type" class="form-label mr-2">Allow Post Without Image</label>

                @error('allow_post_without_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button class="btn btn-success">Create</button>
        </form>
    </div>
@endsection
