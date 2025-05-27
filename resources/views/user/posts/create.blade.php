@extends('user.layout')

@section('content')
    <div class="container">
        <h2>Create New Post</h2>
        <hr>
        
        <form action="{{ route('user.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Title <small class="text-muted"
                        id="titleCounter">(0/100)</small></label>
                <input type="text" class="form-control" name="title" id="title" maxlength="100" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <!-- Platform -->
            <div class= "mb-3">

                <select name="platform_ids[]" id="platform_id" class="form-select" required multiple
                    onChange="applyPlatformValidation(this.value)">
                    <option value="">Select Platform</option>
                    @foreach ($platforms as $platform)
                        <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                    @endforeach
                </select>
                @error('platform_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" class="form-control" rows="6" required></textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label for="image" class="form-label">Image </label>
                <input type="file" class="form-control" name="image" accept="image/*" id="image">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror    
            </div>

            <!-- Scheduled Date & Time -->
            <div class="mb-3">
                <label for="scheduled_for" class="form-label">Schedule Post</label>
                <input type="datetime-local" name="scheduled_time" class="form-control">
                @error('scheduled_for')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror    
            </div>

            <button type="submit" class="btn btn-primary">Save Post</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        function applyPlatformValidation(id) {
            platformRules = @json($platforms);
            selectedPlatform = platformRules.find(p => p.id == id);
            console.log(selectedPlatform);
            if (!platformRules) {
                console.error('Platform not found');
                return;
            }
            let max_post_words_count = selectedPlatform.max_post_words_count == null ? 100 : selectedPlatform
                .max_post_words_count;
            let image_is_required = selectedPlatform.allow_post_without_image == 0 ? true : false
            document.getElementById('title').setAttribute('maxLength', max_post_words_count);
            if (image_is_required) {
                document.getElementById('image').setAttribute('required', true);
            } else {
                document.getElementById('image').removeAttribute('required');

            }
        }
    </script>
@endsection
