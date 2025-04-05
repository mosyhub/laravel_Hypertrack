@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>User Management</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover mt-3">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Profile</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" width="50" height="50" class="rounded-circle">
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="form-inline d-flex">
                            @csrf
                            <select name="role" class="form-control mr-2">
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
