<div class="card">
    <form action="{{ route('users.updateProfile', $user->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="card-header">
            Profile
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-control @error('type') is-invalid @enderror">
                    @foreach (['PJ', 'PF'] as $type)
                        <option value="{{ $type }}" @selected(old('type') === $type || $user?->profile?->type)>{{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                    value="{{ old('address') ?? $user?->profile?->address }}">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </form>
</div>