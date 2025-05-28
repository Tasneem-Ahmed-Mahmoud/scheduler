@extends('user.layout')

@section('content')
<div class="container py-5">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Manage Platforms</h2>
        <button class="btn btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#platformModal">
            <i class="bi bi-pencil-square me-1"></i> Edit Platforms
        </button>
    </div>

    {{-- Platforms Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allPlatforms as $platform)
                            <tr>
                                <td class="fw-medium">{{ $platform->name }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ in_array($platform->id, $userPlatforms) ? 'success' : 'secondary' }}">
                                        {{ in_array($platform->id, $userPlatforms) ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-4">No platforms available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="platformModal" tabindex="-1" aria-labelledby="platformModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('user.platforms.sync') }}">
            @csrf
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="platformModalLabel">change platforms Status</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach($allPlatforms as $platform)
                        <div class="form-check mb-2">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="platforms[]"
                                value="{{ $platform->id }}"
                                id="platform-{{ $platform->id }}"
                                {{ in_array($platform->id, $userPlatforms) ? 'checked' : '' }}>
                            <label class="form-check-label" for="platform-{{ $platform->id }}">
                                {{ $platform->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-success w-100">Save Platforms</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
