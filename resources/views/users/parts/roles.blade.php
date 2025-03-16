<div class="card">
    <form action="{{ route('users.updateRoles', $user->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="card-header">
            Roles
        </div>
        <div class="card-body">
            @foreach ($roles as $role)
                <div class="form-check">
                    <input class="form-check-input @error('roles') is-invalid @enderror " type="checkbox"
                        value="{{ $role->id }}" name="roles[]" @checked(in_array($role->name, $user->roles->pluck('name')->toArray()))>
                    <label class="form-check-label">
                        {{ $role->name }}
                    </label>

                    @if($loop->last)
                        @error('roles')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    @endif

                </div>
            @endforeach
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </form>
</div>