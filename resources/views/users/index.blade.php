@extends('layouts.default')
@section('page-title', 'Users')
@section('page-actions')
    <a href="{{ route('users.create') }}" class="btn btn-primary">Create </a>
@endsection
@section('content')
    @session('status')
        <div class="alert alert-success">{{ $value }}</div>
    @endsession

    <form action="{{ route('users.index') }}" style="width: 300px" method="get" class="mb-3">
        <div class="input-group input-group-sm">
            <input type="text" name="keyword" class="form-control" placeholder="Search">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th class="col">#</th>
                <th class="col">Name</th>
                <th class="col">Email</th>
                <th class="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="col">{{ $user->id }}</td>
                    <td class="col">{{ $user->name }}</td>
                    <td class="col">{{ $user->email }}</td>
                    <td>
                        @can('edit', \App\Models\User::class)
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        @endcan

                        @can('destroy', \App\Models\User::class)
                            <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
@endsection